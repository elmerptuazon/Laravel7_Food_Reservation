<?php
namespace App\Globals;
 
use App\Models\ClassType;
use App\Models\ClassModel;
use App\Models\Trainer;
use App\Models\TimeSchedule;
use App\Models\DateSchedule;
use App\Models\CMSconfig;
use App\Models\Package;

class FrontConfig
{
	public $config = [];

    public function getConfig()
    {
        $this->config['cms'] = CMSconfig::get();
        $this->config['cms_ordered'] = [];

        foreach($this->config['cms'] as $key => $value)
        {
            $this->config['cms_ordered'][$value->cms_config_page][$value->cms_config_name] = $value->cms_config_value;
        }

        $this->config['company']    = 'Ultra Lagree';
        $this->config['address']    = $this->config['cms_ordered']['Contact']['Address'];
        $this->config['branch']     = $this->config['cms_ordered']['Contact']['Branch'];
        $this->config['number']     = $this->config['cms_ordered']['Contact']['Number'];
        $this->config['email']      = $this->config['cms_ordered']['Contact']['Email'];


        $Workouts = [];
        $Workouts_type = [];

        $count_ct = ClassType::active()->count();
        if($count_ct >= 1)
        {
        	$wt = ClassType::active()->get()->keyBy('class_type_id');

        	foreach($wt as $key => $value)
        	{
        		$Workouts_type[$value->class_type_id] = $value->class_type_title;
        	}

        }

        $wo = ClassModel::details()->banners()->bodyPartsConcat()->with('itemstobring')->groupBy('tbl_class.class_id')->get();
        $no_active_wo = 0;

        foreach($wo as $key => $value)
        {
        	$Workouts[$value->class_id]['title'] 			= $value->class_name;
        	$Workouts[$value->class_id]['current'] 			= 0;
        	if($no_active_wo == 0)
        	{
        		$Workouts[$value->class_id]['current'] 		= 1;
        	}
			$Workouts[$value->class_id]['Workouts_type'] 	= $value->class_type_id;
			$Workouts[$value->class_id]['difficulty'] 		= strtolower($value->difficulty_name);
			$Workouts[$value->class_id]['minutes'] 			= $value->class_duration;
			$Workouts[$value->class_id]['sweat_level'] 		= $value->class_sweat_level;
			$Workouts[$value->class_id]['key_body_parts'] 	= $value->body_parts;
			$Workouts[$value->class_id]['description'] 		= $value->class_description;
			$Workouts[$value->class_id]['link'] 			= "";
			$Workouts[$value->class_id]['img'] 				= $value->class_picture;
			$Workouts[$value->class_id]['img-bg'] 			= $value->class_picture;
			$Workouts[$value->class_id]['banner-1'] 		= $value->banner_picture_1;
			$Workouts[$value->class_id]['banner-2'] 		= $value->banner_picture_2;
			$Workouts[$value->class_id]['banner-3'] 		= $value->banner_picture_3;
			$Workouts[$value->class_id]['banner-4'] 		= $value->banner_picture_4;
			$Workouts[$value->class_id]['itemstobring']  	= $value->itemstobring;

			if($Workouts[$value->class_id]['itemstobring'] == null)
			{
				$Workouts[$value->class_id]['itemstobring'] = [];
			}
        }

        
        $Trainers = [];
        $t = Trainer::details()->where('trainer_picture', '!=', '/media/no-profile-picture-icon-15.jpg')->with('classes')->get()->keyBy('trainer_id');

        foreach($t as $key => $value)
        {
            $Trainers[$key]['id'] = $value->trainer_id;
            $Trainers[$key]['name'] = $value->trainer_fname . ' '. $value->trainer_lname;
            $Trainers[$key]['img'] = $value->trainer_picture;
            $Trainers[$key]['details'] = $value->trainer_description;
            $Trainers[$key]['link'] = '';
            $Trainers[$key]['address'] = $value->trainer_address;
            $Trainers[$key]['classes'] = $value->classes;
        }

		$Studios[0]['title'] = 'SPIN ROOM';
		$Studios[0]['details'] = 'Lorem Ipsum';
		$Studios[0]['desc'] = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.";
		$Studios[0]['desc_2'] = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.";
		$Studios[0]['img_header'] = '/Front/Theme/wp-content/uploads/2018/03/spin_room_hp.jpg';
		$Studios[0]['img_1'] = '/Front/Theme/wp-content/uploads/2018/03/spin_room_1.jpg';
		$Studios[0]['img_2'] = '/Front/Theme/wp-content/uploads/2018/03/spin_room_2.jpg';

		$Studios[1]['title'] = 'BARRE STUDIO';
		$Studios[1]['details'] = 'Lorem Ipsum';
		$Studios[1]['desc'] = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.";
		$Studios[1]['desc_2'] = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.";
		$Studios[1]['img_header'] = '/Front/Theme/wp-content/uploads/2018/03/barre_studio_hp.jpg';
		$Studios[1]['img_1'] = '/Front/Theme/wp-content/uploads/2018/04/barre-studio-3.jpg';
		$Studios[1]['img_2'] = '/Front/Theme/wp-content/uploads/2018/04/barre-studio-4.jpg';

		$Studios[2]['title'] = 'HALO TRX ROOM';
		$Studios[2]['details'] = 'Lorem Ipsum';
		$Studios[2]['desc'] = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.";
		$Studios[2]['desc_2'] = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.";
		$Studios[2]['img_header'] = '/Front/Theme/wp-content/uploads/2018/03/halo_trx_studio_hp.jpg';
		$Studios[2]['img_1'] = '/Front/Theme/wp-content/uploads/2018/02/halo-trx-2.jpg';
		$Studios[2]['img_2'] = '/Front/Theme/wp-content/uploads/2018/02/halo-trx-1.jpg';

		$Studios[3]['title'] = 'PILATES LOFT';
		$Studios[3]['details'] = 'Lorem Ipsum';
		$Studios[3]['desc'] = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.";
		$Studios[3]['desc_2'] = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.";
		$Studios[3]['img_header'] = '/Front/Theme/wp-content/uploads/2018/03/pilates_room_hp.jpg';
		$Studios[3]['img_1'] = '/Front/Theme/wp-content/uploads/2018/03/pilates-reformer-3.jpg';
		$Studios[3]['img_2'] = '/Front/Theme/wp-content/uploads/2018/02/pilates-loft-1.jpg';

        $wouts['classess']['details'] = 'Our signature 45-minute class is a full-body workout. It’s an intense mix of cardio, weight and strength training performed on the revolutionary Megaformer machine. Music accompanies the moves, so you’re sure to keep your adrenaline up and your heart pumping. Each class has seven slots that are open to all levels, whether beginner, intermediate or advanced. Don’t worry about not getting the optimum workout. Our coaches are trained on proper adjustments and modifications. We guarantee individual attention. Whatever your level is, be ready to sweat, shake and push every single muscle into peak performance.';
        $wouts['classess']['title'] = 'Classes';
        $wouts['classess']['img'] = '/images/Final/CLASSES/classes.jpg';
        $wouts['megaformer']['details'] = 'At the core of the 45-minute Lagree Fitness workout is the Megaformer machine, a fitness equipment designed by Hollywood-based celebrity fitness guru Sebastien Lagree. It’s built to meet workout demands across fitness levels, ages and body types. The Megaformer makes it possible to combine resistance training and cardio into one seamless and efficient workout. As every single muscle stretches and contracts, the machine keeps you balanced and true to the optimal form. The result: up to 800 calories burned, leading to a stronger, tighter and more toned body, all in less than an hour.';
        $wouts['megaformer']['title'] = 'Megaformer';
        $wouts['megaformer']['img'] = '/images/Final/MEGAFORMER/MEGAFORMER2.jpg';
        $wouts['100club']['details'] = 'We value your trust in Ultra Lagree. As a reward, we have put together a membership program exclusive to our first 100 sign-ups.

For a one-time investment of P28,000.00, be one of our 100 Club members and get access to our classes. In addition, you also get:
30 sessions valid for 1 year
A free session on your birthday month
5% lifetime discount on classes (non-transferable)
Annual 15 days “freeze” schedule
Free one-time body assessment and consultation
Unlimited long black coffee

P5,000 worth of Ultra Lagree merchandise, including:
Grip gloves, 5-finger grip socks, Towel, Dri-fit shirt and Tote bag
Partner freebies, including:
Kana Kare Oriental Soap Set and Assorted GCs from our brand partners';
        $wouts['100club']['title'] = 'Club 100 Members';
        $wouts['100club']['img'] = '/images/Final/CLUB 100/CLUB100 2.jpg';
        
 
		$this->config['Trainers'] = $Trainers;
		$this->config['Workouts'] = $Workouts;
		$this->config['Studios']  = $Studios;
        $this->config['wouts'] = $wouts;
		$this->config['Workouts_type'] = $Workouts_type;
        
		return $this->config;
    }
}