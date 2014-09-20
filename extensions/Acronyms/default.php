<?php
/*
Extension Name: Acronyms
Extension Url: #
Description: Replace instances of defined acronyms in comments with the full HTML acronym tag. This plugin is based on Joel Pan's Acronyms Wordpress plugin.
Version: 0.1
Author: Michael Rainey
Author Url: http://raineym.net63.net/
*/

   // Make sure this file was not accessed directly and prevent register_globals configuration array attack
   if (!defined('IN_VANILLA')) exit();

   // Set Definitions
   $Context->SetDefinition('ExtensionOptions', 'Extension Options');
   $Context->SetDefinition('Acronyms', 'Acronyms');
   $Context->SetDefinition('AcronymSettings', 'Acronym Settings');
   $Context->SetDefinition('AcronymList', 'Acronym List &#040;put each Acronym => Title pair on a separate line&#041;');

   // Language dictionary
   $Context->Dictionary['AcronymErrCreateTable'] = 'Could not create Acronym database table!';
   $Context->Dictionary['AcronymErrCreateConfig'] = 'Could not save Acronym settings to configuration file!';
   $Context->Dictionary['AcronymsErrImportFile'] = 'Could not import default Acronyms file!';

   if (!array_key_exists('ACRONYM_VERSION', $Configuration)) {
      $Errors = 0;
      $TableDrop = "DROP TABLE IF EXISTS `".$Configuration['DATABASE_TABLE_PREFIX']."Acronyms`";
      if (!mysql_query($TableDrop, $Context->Database->Connection)) {
         $Errors = 1;
      }
      $TableCreate = "CREATE TABLE `".$Configuration['DATABASE_TABLE_PREFIX']."Acronyms` (`AcronymID` int(11) NOT NULL auto_increment, `AcronymIndex` text NOT NULL, PRIMARY KEY (`AcronymID`))";
      if (!mysql_query($TableCreate, $Context->Database->Connection)) {
         $Errors = 1;
      }
      if ($Errors == 0) {
         $AcronymIndexFile = $Configuration['EXTENSIONS_PATH'].'Acronyms/acronyms.txt';
         if(file_exists($AcronymIndexFile)) {
            $AcronymIndex = file_get_contents($AcronymIndexFile);
            if($AcronymIndex !== FALSE) {
               $TablePopulate = "INSERT INTO `".$Configuration['DATABASE_TABLE_PREFIX']."Acronyms` (AcronymID,AcronymIndex) VALUES (1,\"".mysql_real_escape_string($AcronymIndex)."\")";
               if (!mysql_query($TablePopulate, $Context->Database->Connection)) {
                  $Errors = 0; // It doesn't matter if the AcronymIndex file is loaded or not.
                  $NoticeCollector->AddNotice($Context->GetDefinition('AcronymErrImportFile'));
               }
            }
         }

         // Add the db structure to the database configuration file
         $Structure = "// Acronym Table Structure
\$DatabaseTables['Acronym'] = 'ACRONYM';
\$DatabaseColumns['Acronym']['AcronymID'] = 'AcronymID';
\$DatabaseColumns['Acronym']['AcronymIndex'] = 'AcronymIndex';
";
         if (!AppendToConfigurationFile($Configuration['APPLICATION_PATH'].'conf/database.php', $Structure)) {
            $Errors = 1;
         }
         if ($Errors == 0) {
            AddConfigurationSetting($Context, 'ACRONYM_VERSION', '0.2');
         }
         else {
            // Could not save configuration
            $NoticeCollector->AddNotice($Context->GetDefinition('AcronymErrCreateConfig'));
         }
      }
      else {
         // Could not create database
         $NoticeCollector->AddNotice($Context->GetDefinition('AcronymErrCreateTable'));
      }
   }

   if(in_array($Context->SelfUrl, array("post.php", "comments.php"))) {
      $Head->AddStyleSheet('extensions/Acronyms/acronyms.css');
   }

   class Acronym extends StringFormatter {

      function Parse($String, $Object, $FormatPurpose) {

         $acronyms = $this->GetAcronyms($Object);
         if ($FormatPurpose == FORMAT_STRING_FOR_DISPLAY) {
            foreach($acronyms as $acronym => $title) {
               $acronym = trim(ltrim(rtrim($acronym)));
               $title = trim(ltrim(rtrim($title)));
               $String = preg_replace("|(?!<[^<>]*?)(?<![?.&])\b" . preg_quote($acronym) . "\b(?!:)(?![^<>]*?>)|msU", "<acronym title=\"$title\">$acronym</acronym>",$String);
            }
         }
         return $String;
      }

      function GetAcronyms($Object) {
         $acronymListDirty = "";
         $acronymListCleaning = "";
         $acronymListClean = "";
         $acronymList = "";
         $list = @mysql_query("SELECT AcronymIndex FROM `".$Object->Context->Configuration['DATABASE_TABLE_PREFIX']."Acronyms` WHERE AcronymID=1",$Object->Context->Database->Connection);
         if(!$list) {
            return FALSE;
         }
         else {
            if(mysql_num_rows($list) == 0) {
               return FALSE;
            }
            else {
               while($row = mysql_fetch_assoc($list)) {
                  $acronymListDirty .= $row["AcronymIndex"] . "\n";
               }
               $acronymListDirty = trim($acronymListDirty);
               $acronymListCleaning = explode("\n", $acronymListDirty);
               for($x = 0; $x < count($acronymListCleaning); $x++) {
                    $acronymListCleaning[$x] = trim($acronymListCleaning[$x]);
                    $acronymListClean = explode("=>", $acronymListCleaning[$x]);
                    $acronymList[trim(trim($acronymListClean[0]),"'")] = trim(trim($acronymListClean[1]),"'");
               }
            }
         }
         return $acronymList;
      }
   }

   // Instantiate the Acronym object and add it to the global manipulators
   $Acronym = $Context->ObjectFactory->NewObject($Context, "Acronym");
   $Context->StringManipulator->AddGlobalManipulator("Acronym", $Acronym);

   if ($Context->SelfUrl == "settings.php" && $Context->Session->User->Permission('PERMISSION_CHANGE_APPLICATION_SETTINGS')) {

      class AcronymForm extends PostBackControl {
         var $ConfigurationManager;

         function AcronymForm(&$Context) {
            $this->Name = 'AcronymForm';
            $this->ValidActions = array('Acronym', 'ProcessAcronym');
			
            // Set ACRONYM_VERSION to 0.1 if it is not set 
            if(!isset($_POST['ACRONYM_VERSION']) || $_POST['ACRONYM_VERSION'] == "") {
               $_POST['ACRONYM_VERSION'] = "0.2";
            }
				
            $this->Constructor($Context);
            if (!$this->Context->Session->User->Permission('PERMISSION_CHANGE_APPLICATION_SETTINGS')) {
               $this->IsPostBack = 0;
            }
            elseif($this->IsPostBack) {
               if(isset($_POST['ACRONYM_LIST'])) {
                  $this->InsertAcronymListIntoDB($_POST['ACRONYM_LIST']);
                  unset($_POST['ACRONYM_LIST']);
               }
               $SettingsFile = $this->Context->Configuration['APPLICATION_PATH'].'conf/settings.php';
               $this->ConfigurationManager = $this->Context->ObjectFactory->NewContextObject($this->Context, 'ConfigurationManager');
               if($this->PostBackAction == 'ProcessAcronym') {
                  // Get the form values
                  $this->ConfigurationManager->GetSettingsFromForm($SettingsFile);
                  if($this->ConfigurationManager->SaveSettingsToFile($SettingsFile)) {
                     Redirect(GetUrl($this->Context->Configuration, 'settings.php', '', '', '', '', 'PostBackAction=Acronym&Success=1'));
                  }
                  else {
                     $this->PostBackAction = 'Acronym';
                  }
               }
            }
            $this->CallDelegate('Constructor');
         }

         function Render() {
            if ($this->IsPostBack) {
               $this->CallDelegate('PreRender');
               $this->PostBackParams->Clear();
               if ($this->PostBackAction == 'Acronym') {
                  $this->PostBackParams->Set('PostBackAction', 'ProcessAcronym');
                  $acronymList = $this->GetAcronymListFromDB();
                  echo '
                           <div id="Form" class="Account DefaultPageSettings">';
                  if (ForceIncomingInt('Success', 0)) echo '<div id="Success">'.$this->Context->GetDefinition('ChangesSaved').'</div>';
                  echo '
                              <fieldset>
                                 <legend>'.$this->Context->GetDefinition("AcronymSettings").'</legend>
                                 '.$this->Get_Warnings().'
                                 '.$this->Get_PostBackForm('frmAcronym').'
                                 <p>DO NOT LEAVE ACRONYM LIST BLANK</b>. Disable the extension instead of deleting list.</p>
                                 <ul>
                                    <li>
                                       <label for="txtAcronymList">'.$this->Context->GetDefinition("AcronymList").'</label>
                                       <textarea name="ACRONYM_LIST" id="txtAcronymList" style="width: 95%;">'.$acronymList.'</textarea>
	                              </li>
                                 </ul>
                                 <input type="hidden" name="ACRONYM_VERSION" id="txtAcronymVersion" value="'.$this->ConfigurationManager->GetSetting('ACRONYM_VERSION').'" />
                                 <div class="Submit">
                                    <input type="submit" name="btnSave" value="'.$this->Context->GetDefinition('Save').'" class="Button SubmitButton" />
                                    <a href="'.GetUrl($this->Context->Configuration, $this->Context->SelfUrl).'" class="CancelButton">'.$this->Context->GetDefinition('Cancel').'</a>
                                 </div>
                              </form>
                              </fieldset>
                           </div>
                           ';
               }
               $this->CallDelegate('PostRender');
            }
         }

         function GetAcronymListFromDB() {
            $acronymList = "";
            $list = @mysql_query("SELECT AcronymIndex FROM `".$this->Context->Configuration['DATABASE_TABLE_PREFIX']."Acronyms` WHERE AcronymID=1",$this->Context->Database->Connection);
            if(!$list) {
               return "Error Returning List From Database. Please Try Again.";
            }
            else {
               if(mysql_num_rows($list) == 0) {
                  return "No Data In Database.";
               }
               else {
                  while ($row = mysql_fetch_assoc($list)) {
                     $acronymList .= $row["AcronymIndex"] . "\n";
                  }
                  $acronymList = trim($acronymList,"\n");
               }
            }
            return $acronymList;
         }

         function InsertAcronymListIntoDB($acronyms) {
            $list = @mysql_query("UPDATE `".$this->Context->Configuration['DATABASE_TABLE_PREFIX']."Acronyms` SET AcronymIndex=\"".mysql_real_escape_string($acronyms)."\" WHERE AcronymID=1",$this->Context->Database->Connection);
         }

      }

	$AcronymForm = $Context->ObjectFactory->NewContextObject($Context, 'AcronymForm');
	$Page->AddRenderControl($AcronymForm, $Configuration["CONTROL_POSITION_BODY_ITEM"] + 1);

	$ExtensionOptions = $Context->GetDefinition('ExtensionOptions');
	$Panel->AddList($ExtensionOptions, 20);
	$Panel->AddListItem($ExtensionOptions, $Context->GetDefinition('Acronyms'), GetUrl($Context->Configuration, 'settings.php', '', '', '', '', 'PostBackAction=Acronym'));

   }

?>