  <?php
  
  class Application_Form_CreateStudy extends Application_Form_Abstract {
	  private $studyModel; 
	  private $island;
	  
	  private function addNumber($name, $label){
		  $element = $this -> createElement('text',$name, [
		  	'helper' => 'formNumber',
			'label' => $label,
			'required' => true ,
		  ]);
		  
		  $this -> addElementWithClass($element);
		  return $element; 
	  } 
	  private function addEnumSelect($name, $label, $col = null){
		  if( $col == null) $col = $name; 
		  $element = $this -> createElement('select' , $name , [
			  'label' => $label,
			  'required' => true , 
			  'class' => 'form-control',
		  ]);
		  
		  $mlist = $this -> studyModel -> getEnumValues($col); 
		  foreach($mlist as $listitem){
			  $element -> addMultiOption($listitem , $listitem ); 
		  }
		  $this -> addElementWithClass($element); 
		return $element; 
	}
	  private function addDate($name , $label, $value = null){
			$element = $this -> createElement('text',$name, [
		  	'helper' => 'formDate',
			'label' => $label,
			'required' => true, 
		  ]);
		  if ($value != null) $element -> setValue($value); 
		  
		  $this -> addElementWithClass($element);
		  return $element;   
	  }
	  private function addTime($name , $label, $value = null){
			$element = $this -> createElement('text',$name, [
		  	'helper' => 'formTime',
			'label' => $label,
			'required' => true , 
		  ]);
		  if ($value != null) $element -> setValue($value); 
		  
		  $this -> addElementWithClass($element);
		  return $element;   
	  }
	  public function init(){ 
	  	parent::init();
		//$this -> addPrefixPath('','','element');
		  //$this -> addElementPrefixPath('Application_Form_Helper',APPLICATION_PATH.'/forms/helpers', 'decorator');
		  if($this -> getAttrib('studyModel') == null) {
			  throw Exception ('You should pass an instance of the study model to the CreateStudy form.'); 		
		  }
		  $this -> studyModel = $this -> getAttrib('studyModel') ;
		  $this -> island = $this -> getAttrib('island'); 
		  $this -> removeAttrib('island'); 
		  $this -> removeAttrib('studyModel'); 
		  $this -> addADescription("guide1", "Select a location from below to see its details such as latitude and longitude and a picture. If you cannot find the location of your field trip in the list, you may create a new location using the appropriate option.") ;
		  //var_dump($element); 
	     $this -> addDate('date','Date of the field trip: ',  date('Y-m-d'));
		  $element = $this -> createElement('select' , 'location_id', [
			  'required' => true,
			  'label' => 'Select the location of your field trip',
			  'class' => 'form-control',
		  ]); 
		  $locationList = $this -> studyModel -> getLocations($this -> island); 
		  //var_dump($locationList) ; 
		  foreach($locationList as $num => $row) {
			  $element -> addMultiOption($row['id'] , $row['location_name']);
		  }
		  $element -> addMultiOption('new-location', 'new location'); 
		  
		  $this -> addElement($element); 
		  // Class info section
		  $this -> addElement('text' , 'exp1', [
			  'value' => '<h1>Please provide the following information about your class:<h1>',
			  'helper' => 'formNote'
		  ]);
		  //numstudents
	      $this -> addTime('low_tide_time','Low tide time: ');

		  $this -> addNumber('num_students', 'Number of students: '); 
		  //num t lines
		  $this -> addNumber('num_transect_lines', 'Number of transect lines: '); 

		  //length t lines
		  $this -> addNumber('length_transect_lines','Length of transect lines: ') ;
		  //point spacing: 
		  $this -> addEnumSelect( 'point_spacing' , 'Distance between transect points: ');
		  //num quadrants
		  $this -> addNumber ('num_quadrants_per_transect','Number of quadrants per transect: '); 
	      $this -> addADescription( 'guide2', 'Please provide the following information about the location and time of your field trip');
		  
		  //Find the view helper FormDate under application/views/helpers
		  $this -> addTime('start_time', 'Start bio survey time: ', date('G:i'));
		  //Find the view helper FormTime under application/views/helpers
			$this -> addTime('stop_time', 'End bio survey time: ',date('G:i'));
		  $this -> addEnumSelect('wind_speed', 'Wind speed: '); 
		  $this -> addEnumSelect('weather', 'Weather Conditions: '); 
		  $this -> addElement('radio' , 'prior_rain',['label' => 'Rain events in prior week? ',
			  'multiOptions' => ['yes' => 'Yes' , 'no' => 'No' ],
			  'label_class' => 'radio-inline',
			  'separator'=> " \n "
			  
		  ]);
		  $this -> addNumber ('rain_amount', 'If Yes, amount of rain: ' );		  
		  //wave height
		  $this -> addEnumSelect('wave_height', 'Average wave height: ');
		  /*$this -> addElement('radio' , 'sand_in_grooves',['label' => 'Sand in grooves/pools? ',
			  'multiOptions' => ['yes' => 'Yes' , 'no' => 'No' ],
		  ]);
		  $this -> addElement('radio' , 'sand_above',['label' => 'Sandy beach above? ',
			  'multiOptions' => ['yes' => 'Yes' , 'no' => 'No' ],
		  ]);
		  $this -> addElement('radio' , 'sand_side',['label' => 'Sandy beach to right or left? ',
			  'multiOptions' => ['yes' => 'Yes' , 'no' => 'No' ],
		  ]);*/
		  
		  
		  //num ppl
		  $this -> addEnumSelect('num_people', 'Number of visitors at the site: '); 
		  //num fishing
		  $this -> addEnumSelect('num_fishing', 'Number of people fishing: ' ); 
		  //num collecting
		  $this -> addEnumSelect('num_collecting', 'Number of people collecting: '); 
		  //collecting
		  $this -> addElement('text' , 'collecting' , [
			  'label' => 'What were they collecting?',
			  'class' => 'form-control',
		  ]);
			  $this -> addElement('textarea' , 'comments' ,[
			  'label' => 'Comments: ',
			  'rows' => 5,
			  'class' => 'form-control'
		  ]);
		  
		  $e = $this -> createElement('submit', 'submit' , ['label' => 'Create report', 'class' => 'btn btn-primary btn-block',]);
		  $e -> removeDecorator('Label');
		  $e -> getDecorator('first')->setOption('class', 'col-xs-8 col-sm-4 col-xs-offset-3');
		  var_dump($e -> getDecorator('first'));
	  	  $this -> addElement($e); 
	  }
  }