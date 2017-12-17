<?php

use Illuminate\Database\Seeder;
use App\Event;

class EventTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	/***********************
    	** 1. OUTDOOR EVENTS  **
    	***********************/
    	
    	// 1a. Track Events - Male
    	$names = ['80m','100m','150m','200m','300m','400m','600m','800m','1000m','1 Μίλι','1500m','3000m στηπλ', '5000m','10000m','Μαραθώνιος'
    	,'110m εμπόδια','110m εμπόδια(91,4cm)','110m εμπόδια(99cm)'
    	,'400m εμπόδια'
    	,'4x80m','4x100m','4x300m','4x400m'];
    	$this->createEvents($names,'track','outdoor','male');
    	
    	// 1b. Track Events - Female
    	$names = ['80m','100m','200m','400m','800m','1 Μίλι','1500m','2000m στήπλ','3000m στήπλ', '5000m','10000m','Ημιμαραθώνιος','Μαραθώνιος','100m εμπόδια','100m εμπόδια(76cm)','400m εμπόδια','4x80m','4x100m','4x300m','4x400m'];
    	$this->createEvents($names,'track','outdoor','female');
    	
    	// 1c. Field Events - Male
    	$names = ['Άλμα εις μήκος','Άλμα εις ύψος','Άλμα επι κοντώ','Άλμα εις τριπλούν',
    		'Σφαιροβολία','Σφαιροβολία(5kg)','Σφαιροβολία(6kg)'
    		,'Σφυροβολία','Σφυροβολία(7.26kg)','Σφυροβολία(6kg)','Σφυροβολία(5kg)'
    		,'Ακοντισμός','Ακοντισμός(700gr)'
    		,'Δισκοβολία','Δισκοβολία(1.5kg)','Δισκοβολία(1.75kg)'
    		,'Δέκαθλο','Δέκαθλο Εφήβων'];
    	$this->createEvents($names,'field','outdoor','male');

    	// 1d. Field Events - Female
    	$names = ['Άλμα εις μήκος','Άλμα εις ύψος','Άλμα επι κοντώ','Άλμα εις τριπλούν',
    		'Σφαιροβολία'
    		,'Σφυροβολία','Σφυροβολία(3kg)'
    		,'Ακοντισμός','Ακοντισμός(500gr)'
    		,'Δισκοβολία','Δισκοβολία(1.5kg)'
    		,'Έπταθλο'];
    	$this->createEvents($names,'field','outdoor','female');

    	
    	/***********************
    	** 2. INDOOR EVENTS  **
    	***********************/
    	
    	// 2a. Track Events - Male
    	$names = ['60m','100m','200m','400m','800m','1 Μίλι','1500m','3000m','60m εμπόδια','4x400m'];
    	$this->createEvents($names,'track','indoor','male');
    	
    	// 2b. Track Events - Female
    	$names = ['60m','100m','200m','400m','800m','1 Μίλι','1500m','3000m','60m εμπόδια'];
    	$this->createEvents($names,'track','indoor','female');
    	
    	// 2c. Field Events - Male
    	$names = ['Άλμα εις μήκος','Άλμα εις ύψος','Άλμα επι κοντώ','Άλμα εις τριπλούν',
    		'Σφαιροβολία','Έπταθλο'];
    	$this->createEvents($names,'field','indoor','male');

    	// 2d. Field Events - Female
    	$names = ['Άλμα εις μήκος','Άλμα εις ύψος','Άλμα επι κοντώ','Άλμα εις τριπλούν',
    		'Σφαιροβολία','Πένταθλο'];
    	$this->createEvents($names,'field','indoor','female');


    	/***********************
    	** 3. CROSS COUNTRY EVENTS  **
    	***********************/
    	
    	// 3.a Male
    	$names = ['5000m','10000m'];
    	$this->createEvents($names,'track','cross country','male');
    	
    	// 3b. Female
    	$names = ['5000m','10000m'];
    	$this->createEvents($names,'track','cross country','female');
    	

	}

    public function createEvents($names,$type,$season,$gender)
    {
    	foreach($names as $name){
    		Event::forceCreate(['name' => $name,'type' => $type,'season' => $season,'gender' => $gender,]);
    	}
    	return 1;
    }

}