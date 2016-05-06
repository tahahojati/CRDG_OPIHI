  <?php
  
  class Application_Form_CreateStudy extends Zend_Form {
	  private $studyModel; 
	  private $island;
	  
	  private function addNumber($name, $label){
		  $element = $this -> createElement('text',$name, [
		  	'helper' => 'formNumber',
			'label' => $label,
		  ]);
		  
		  $this -> addElement($element);
		  return $element; 
	  } 
	  private function addEnumSelect($name, $label, $col = null){
		  if( $col == null) $col = $name; 
		  $element = $this -> createElement('select' , $name , [
			  'label' => $label,
		  ]);
		  
		  $mlist = $this -> studyModel -> getEnumValues($col); 
		  foreach($mlist as $listitem){
			  $element -> addMultiOption($listitem , $listitem ); 
		  }
		  $this -> addElement($element); 
		return $element; 
	}
	  public function init(){ 
		  //$this -> addElementPrefixPath('Application_Form_Helper',APPLICATION_PATH.'/forms/helpers', 'decorator');
		  if($this -> getAttrib('studyModel') == null) {
			  throw Exception ('You should pass an instance of the study model to the CreateStudy form.'); 		
		  }
		  $this -> studyModel = $this -> getAttrib('studyModel') ;
		  $this -> island = $this -> getAttrib('island'); 
		  $this -> removeAttrib('island'); 
		  $this -> removeAttrib('studyModel'); 
		  $element = $this -> createElement('text', 'guide1' ,[
		  'helper' => 'formNote', 
		  'value' => "Select a location from below to see its details such as latitude and longitude and a picture. If you cannot find the location of your field trip in the list, you may create a new location using the appropriate option."
		  ]) ;
		  //var_dump($element); 
		  $this -> addElement($element); 
		  $element = $this -> createElement('select' , 'studyLocation', [
			  'required' => true,
			  'label' => 'Select the location of your field trip',
		  ]); 
		  $locationList = $this -> studyModel -> getLocations($this -> island); 
		  var_dump($locationList) ; 
		  foreach($locationList as $num => $row) {
			  $element -> addMultiOption($row['id'] , $row['location_name']);
		  }
		  $element -> addMultiOption('new-location', 'new location'); 
		  
		  $this -> addElement($element); 
		  // Class info section
		  $element = $this -> createElement('text' , 'exp1', [
			  'value' => 'Please provide the following information about your class:'
		  ]);
		  $element -> helper = 'formNote'; 
		  $this -> addElement($element);  
		  //numstudents
		  $this -> addNumber('num_students', 'How many students went on this field trip?'); 
		  //num t lines
		  $this -> addNumber('num_transect_lines', 'How many transect lines were sampled?'); 

		  //length t lines
			  $this -> addNumber('length_transect_lines','Enter the length of each transect line:') ;
		  //point spacing: 
		  $element = $this -> addEnumSelect( 'point_spacing' , 'Point-spacing of transect lines: ');
		  //num quadrants
		  $this -> addNumber ('num_quadrants','Number of quadrants per transect line: '); 
	  $this -> addElement('text', 'exp2', [
		  'value' => 'Please provide the following information about the location and time of your field trip',
		  'helper' => 'formNote'
	  ]);
		  
		  $element = $this -> createElement('text','date',[
			  'label' => 'Date of the field trip: ',
			  'value' => date('Y-m-d')
		  ]);
		  //Find the view helper FormDate under application/views/helpers
		  $element -> helper = 'formDate' ; 
		  $this -> addElement($element); 
			  $element = $this -> createElement('text','start_time',[
			  'label' => 'From: ',
			  'value' => date('G:i')
		  ]);
		  //Find the view helper FormTime under application/views/helpers
		  $element -> helper = 'formTime' ; 
		  $this -> addElement($element); 
			  $this -> addElement($element); 
			  $element = $this -> createElement('text','end_time',[
			  'label' => 'To: ',
			  'value' => date('G:i')
		  ]);
		  //Find the view helper FormTime under application/views/helpers
		  $element -> helper = 'formTime' ; 
		  $this -> addElement($element); 
			  $this -> addElement($element); 
			  $element = $this -> createElement('text','low_tide_time',[
			  'label' => 'Low tide time: ',
		  ]);
		  //Find the view helper FormTime under application/views/helpers
		  $element -> helper = 'formTime' ; 
		  $this -> addElement($element); 
		  $this -> addEnumSelect('wind_speed', 'Wind speed: '); 
		  $this -> addEnumSelect('weather', 'Weather Conditions: '); 
		  $this -> addElement('radio' , 'rain',['label' => 'Did it rain either today or yesterday?',
			  'multiOptions' => ['yes' => 'yes' , 'no' => 'no' ],
		  ]);
		  $element = $this -> createElement ('text' , 'rain_amount', [
			  'label' => 'If it rained, how much?' ,
			  'disabled' => 'true' ,
		  ]
		  );
		  $element -> helper = 'formNumber'; 
		  $this -> addElement($element); 
		  
		  //wave height
		  $this -> addEnumSelect('wave_height', 'Average wave height: ');
		  //num ppl
		  $this -> addEnumSelect('num_people', 'Number of visitors at the site: '); 
		  //num fishing
		  $this -> addEnumSelect('num_fishing', 'Number of people fishing: ' ); 
		  //num collecting
		  $this -> addEnumSelect('num_collecting', 'Number of people collecting: '); 
		  //collecting
		  $element = $this -> createElement('text' , 'collecting' , [
			  'label' => 'What were they collecting?'
		  ]);
			  $this -> addElement('textarea' , 'comments' ,[
			  'label' => 'Comments: '
		  ]);
	  }
  }