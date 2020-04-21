<?php
namespace App\Helpers;

use App\Helpers\Contracts\HelperContract; 
use Crypt;
use Carbon\Carbon; 
use Mail;
use Auth;
use \Swift_Mailer;
use \Swift_SmtpTransport;
use App\User;
use App\UserData;
use App\DriverData;
use App\Settings;
use App\DriverLocations;
use App\Locations;
use App\Trips;
use GuzzleHttp\Client;

class Helper implements HelperContract
{    

            public $emailConfig = [
                           'ss' => 'smtp.gmail.com',
                           'se' => 'uwantbrendacolson@gmail.com',
                           'sp' => '587',
                           'su' => 'uwantbrendacolson@gmail.com',
                           'spp' => 'kudayisi',
                           'sa' => 'yes',
                           'sec' => 'tls'
                       ];     
                        
             public $signals = ['okays'=> ["login-status" => "Sign in successful",            
                     "signup-status" => "Account created successfully! You can now login to complete your profile.",
                     "create-driver-status" => "Driver account created successfully!",
                     "update-driver-status" => "Driver account updated successfully!",
                     "update-status" => "Account updated!",
                     "config-status" => "Config added/updated!",
                     "contact-status" => "Message sent! Our customer service representatives will get back to you shortly.",
                     ],
                     'errors'=> ["login-status-error" => "There was a problem signing in, please contact support.",
					 "signup-status-error" => "There was a problem signing in, please contact support.",
					 "update-status-error" => "There was a problem updating the account, please contact support.",
					 "contact-status-error" => "There was a problem sending your message, please contact support.",
					 "create-driver-status-error" => "There was a problem creating driver account, please contact support.",
					 "update-driver-status-error" => "There was a problem updating driver info, please contact support.",
                    ]
                   ];
				   
	
/**
 * Polyline encoding & decoding methods
 *
 * Convert list of points to encoded string following Google's Polyline
 * Algorithm.
 *
 * @category Mapping
 * @package  Polyline
 * @author   E. McConville <emcconville@emcconville.com>
 * @license  http://www.gnu.org/licenses/lgpl.html LGPL v3
 * @link     https://github.com/emcconville/google-map-polyline-encoding-tool
 */
	
	/**
     * Default precision level of 1e-5.
     *
     * Overwrite this property in extended class to adjust precision of numbers.
     * !!!CAUTION!!!
     * 1) Adjusting this value will not guarantee that third party
     *    libraries will understand the change.
     * 2) Float point arithmetic IS NOT real number arithmetic. PHP's internal
     *    float precision may contribute to undesired rounding.
     *
     * @var int $precision
     */
    protected static $precision = 5;


/**
     * Apply Google Polyline algorithm to list of points.
     *
     * @param array $points List of points to encode. Can be a list of tuples,
     *                      or a flat, one-dimensional array.
     *
     * @return string encoded string
     */
    final public static function encode( $points )
    {
        $points = self::flatten($points);
        $encodedString = '';
        $index = 0;
        $previous = array(0,0);
        foreach ( $points as $number ) {
            $number = (float)($number);
            $number = (int)round($number * pow(10, static::$precision));
            $diff = $number - $previous[$index % 2];
            $previous[$index % 2] = $number;
            $number = $diff;
            $index++;
            $number = ($number < 0) ? ~($number << 1) : ($number << 1);
            $chunk = '';
            while ( $number >= 0x20 ) {
                $chunk .= chr((0x20 | ($number & 0x1f)) + 63);
                $number >>= 5;
            }
            $chunk .= chr($number + 63);
            $encodedString .= $chunk;
        }
        return $encodedString;
    }

    /**
     * Reverse Google Polyline algorithm on encoded string.
     *
     * @param string $string Encoded string to extract points from.
     *
     * @return array points
     */
    final public static function decode( $string )
    {
        $points = array();
        $index = $i = 0;
        $previous = array(0,0);
        while ($i < strlen($string)) {
            $shift = $result = 0x00;
            do {
                $bit = ord(substr($string, $i++)) - 63;
                $result |= ($bit & 0x1f) << $shift;
                $shift += 5;
            } while ($bit >= 0x20);

            $diff = ($result & 1) ? ~($result >> 1) : ($result >> 1);
            $number = $previous[$index % 2] + $diff;
            $previous[$index % 2] = $number;
            $index++;
            $points[] = $number * 1 / pow(10, static::$precision);
        }
        return $points;
    }

    /**
     * Reduce multi-dimensional to single list
     *
     * @param array $array Subject array to flatten.
     *
     * @return array flattened
     */
    final public static function flatten( $array )
    {
        $flatten = array();
        array_walk_recursive(
            $array, // @codeCoverageIgnore
            function ($current) use (&$flatten) {
                $flatten[] = $current;
            }
        );
        return $flatten;
    }

    /**
     * Concat list into pairs of points
     *
     * @param array $list One-dimensional array to segment into list of tuples.
     *
     * @return array pairs
     */
    final public static function pair( $list )
    {
        return is_array($list) ? array_chunk($list, 2) : array();
    }



/********************************************************************************************************************/


          function sendEmailSMTP($data,$view,$type="view")
           {
           	    // Setup a new SmtpTransport instance for new SMTP
                $transport = "";
if($data['sec'] != "none") $transport = new Swift_SmtpTransport($data['ss'], $data['sp'], $data['sec']);

else $transport = new Swift_SmtpTransport($data['ss'], $data['sp']);

   if($data['sa'] != "no"){
                  $transport->setUsername($data['su']);
                  $transport->setPassword($data['spp']);
     }
// Assign a new SmtpTransport to SwiftMailer
$smtp = new Swift_Mailer($transport);

// Assign it to the Laravel Mailer
Mail::setSwiftMailer($smtp);

$se = $data['se'];
$sn = $data['sn'];
$to = $data['em'];
$subject = $data['subject'];
                   if($type == "view")
                   {
                     Mail::send($view,$data,function($message) use($to,$subject,$se,$sn){
                           $message->from($se,$sn);
                           $message->to($to);
                           $message->subject($subject);
                          if(isset($data["has_attachments"]) && $data["has_attachments"] == "yes")
                          {
                          	foreach($data["attachments"] as $a) $message->attach($a);
                          } 
						  $message->getSwiftMessage()
						  ->getHeaders()
						  ->addTextHeader('x-mailgun-native-send', 'true');
                     });
                   }

                   elseif($type == "raw")
                   {
                     Mail::raw($view,$data,function($message) use($to,$subject,$se,$sn){
                            $message->from($se,$sn);
                           $message->to($to);
                           $message->subject($subject);
                           if(isset($data["has_attachments"]) && $data["has_attachments"] == "yes")
                          {
                          	foreach($data["attachments"] as $a) $message->attach($a);
                          } 
                     });
                   }
           }    

           function createUser($data)
           {
           	$ret = User::create([
                                                      'email' => $data['email'], 
                                                      'email_status' => "unverified", 
                                                      'phone' => $data['phone'], 
													  'phone_status' => "verified",
                                                      'tk' => $data['tk'], 
                                                      'fname' => $data['fname'], 
                                                      'lname' => $data['lname'], 
                                                      'role' => $data['role'], 
                                                      'status' => "enabled", 
                                                      'type' => $data['type'], 
                                                      'password' => bcrypt($data['pass']), 
													  
                                                      ]);
			$data['user_id'] = $ret->id;
			
			switch($data['type'])
			{
				case "driver":
				  $ud = $this->createDriverData($data);
				break;
				
				case "user":
				  $ud = $this->createUserData($data);
				break;
			}
                                                      
                return $ret;
           }
		   
		   function createUserData($data)
           {
           	$ret = UserData::create([
                                                      'user_id' => $data['user_id'],
                                                      'gender' => $data['gender'],
													  'img' => $data['img'], 
                                                      ]);
                                                      
                return $ret;
           }
		   
		   function createDriverData($data)
           {
           	$ret = DriverData::create([
                                                      'user_id' => $data['user_id'],
                                                      'gender' => $data['gender'],
													  'img' => $data['img'], 
                                                      ]);
                                                      
                return $ret;
           }

		   
		   function bomb($data) 
           {
           	//form query string
               $qs = "sn=".$data['sn']."&sa=".$data['sa']."&subject=".$data['subject'];

               $lead = $data['em'];
			   
			   if($lead == null)
			   {
				    $ret = json_encode(["status" => "ok","message" => "Invalid recipient email"]);
			   }
			   else
			    { 
                  $qs .= "&receivers=".$lead."&ug=deal"; 
               
                  $config = $this->emailConfig;
                  $qs .= "&host=".$config['ss']."&port=".$config['sp']."&user=".$config['su']."&pass=".$config['spp'];
                  $qs .= "&message=".$data['message'];
               
			      //Send request to nodemailer
			      $url = "https://radiant-island-62350.herokuapp.com/?".$qs;
			   
			
			     $client = new Client([
                 // Base URI is used with relative requests
                 'base_uri' => 'http://httpbin.org',
                 // You can set any number of default request options.
                 //'timeout'  => 2.0,
                 ]);
			     $res = $client->request('GET', $url);
			  
                 $ret = $res->getBody()->getContents(); 
			 
			     $rett = json_decode($ret);
			     if($rett->status == "ok")
			     {
					//  $this->setNextLead();
			    	//$lead->update(["status" =>"sent"]);					
			     }
			     else
			     {
			    	// $lead->update(["status" =>"pending"]);
			     }
			    }
              return $ret; 
           }
		   
		   function getUser($id)
           {
			   /**
                                                      'tk' => $data['tk'], 
                                                      'role' => $data['role'], 
                                                      'status' => "enabled", 
                                                      'type' => $data['type'], 
                                                      'password' => bcrypt($data['pass']), 
			   **/
           	$ret = [];
               $u = User::where('email',$id)
			            ->orWhere('id',$id)->first();
 
              if($u != null)
               {
                   	$temp['fname'] = $u->fname; 
                       $temp['lname'] = $u->lname; 
                       $temp['phone'] = $u->phone; 
                       $temp['phone_status'] = $u->phone_status; 
                       $temp['email'] = $u->email; 
                       $temp['email_status'] = $u->email_status; 
                       $temp['role'] = $u->role; 
                       $temp['status'] = $u->status; 
                       $temp['type'] = $u->type; 
                       $temp['id'] = $u->id; 
                       $temp['tk'] = $u->tk; 
                       $temp['date'] = $u->created_at->format("jS F, Y h:i"); 
					   
					   switch($temp['type'])
					   {
						   case "driver":
						    $temp['data'] = $this->getDriverData($temp['id']);
						   break;
						   
						   case "user":
						    $temp['data'] = $this->getUserData($temp['id']);
						   break;
					   }
					   
                       $ret = $temp; 
               }                          
                                                      
                return $ret;
           }
		   
		   function getUserData($id)
           {
           	$ret = [];
              $ud = UserData::where('user_id',$id)->first();
 
              if($ud != null)
               {
				  $ret['id'] = $ud->id;
				  $ret['user_id'] = $ud->user_id;
				  $ret['gender'] = $ud->gender;
				  $ret['img'] = $ud->img;
               }                         
                                                      
                return $ret;
           }
		   
		   function getDriverData($id)
           {
           	$ret = [];
              $ud = DriverData::where('user_id',$id)->first();
 
              if($ud != null)
               {
				  $ret['id'] = $ud->id;
				  $ret['user_id'] = $ud->user_id;
				  $ret['gender'] = $ud->gender;
				  $ret['img'] = $ud->img;
               }                         
                                                      
                return $ret;
           }
		   
		   
		   function getUsers($type="")
           {
           	$ret = [];
			  $users = null;
			  
              if($type == "")
			  {
				$users = User::where('id','>',"0")->get();  
			  } 
			  else
			  {
				$users = User::where('type',$type)->get();  
			  }
              
 
              if($users != null)
               {
				  foreach($users as $u)
				  {
					  $uu = $this->getUser($u->id);
					  array_push($ret,$uu);
				  }
               }                         
                                                      
                return $ret;
           }
		   
		   
		   function updateUser($data)
           {		
				$uu = User::where('id', $data['xf'])->first();
				
				if(!is_null($uu))				
				{
					$uu->update(['fname' => $data['fname'], 
                                                      'lname' => $data['lname'],
                                                     'email' => $data['email'],
                                                     'email_status' => $data['email_status'],
                                                'phone' => $data['phone'],
                                                'phone_status' => $data['phone_status'],
                                              'role' => $data['role'], 
                                              'type' => $data['type'], 
                                              'status' => $data['status'], 
                                              'tk' => $data['tk'] 
                                                      ]);

                  switch($uu->type)
				  {
					  case "driver":
					    $this->updateDriverData($data);
					  break;
					  
					  case "user":
					    $this->updateUserData($data);
					  break;
				  }													  
				}
					
           }
		   
		   function updateUserData($data)
           {		
				$ud = UserData::where('user_id', $data['xf'])->first();
				
				if(!is_null($ud))				
				{
					$ud->update(['gender' => $data['gender'], 
                                                      'img' => $data['img']
                                                      ]);												  
				}
					
           }

		   function updateDriverData($data)
           {		
				$ud = DriverData::where('user_id', $data['xf'])->first();
				
				if(!is_null($ud))				
				{
					$ud->update(['gender' => $data['gender'], 
                                                      'img' => $data['img']
                                                      ]);												  
				}
					
           }
		   
		    function isAdmin($user)
           {
           	$ret = false; 
               if($user->role === "admin" || $user->role === "su") $ret = true; 
           	return $ret;
           }
		   
		   function isValidUser($data)
		   {
			 return (Auth::attempt(['email' => $data['id'],'password' => $data['password'],'status'=> "enabled"]) || Auth::attempt(['phone' => $data['id'],'password' => $data['password'],'status'=> "enabled"]));
		   }
		   
		    function getSettings()
           {
           	$ret = [];
              $settings = Settings::where('id','>',"0")->get();
 
              if($settings != null)
               {
				  foreach($settings as $s)
				  {
					  $temp = [];
					  $temp['item'] = $s->item;
					  $temp['value'] = $s->value;
					  array_push($ret,$temp);
				  }
               }                         
                                                      
                return $ret;
           }

		   function getDriverLocations()
           {
           	$ret = [];
              $locs = DriverLocations::where('id','>',"0")->get();
 
              if($locs != null)
               {
				  foreach($locs as $l)
				  {
					  $temp = [];
					  $temp['driver_id'] = $l->driver_id;
					  $temp['latlng'] = $l->latlng;
					  array_push($ret,$temp);
				  }
               }                         
                                                      
                return $ret;
           }
		   
		   function updateDriverLocation($data)
           {		

				$dl = DriverLocations::where('id', $data['driver_id'])->first();
				
				if(is_null($dl))
                {
					DriverLocations::create([
					              'driver_id' => $data['driver_id'], 
                                  'latlng' => $data['latlng']
								  ]);
				}	
                else				
				{
					$dl->update(['latlng' => $data['latlng']]);	
				}
					
           }
		   
		    function appSignup($data)
		   {
			$this->createUser($data);
			$ret = ['status' => "ok",'message' => "User created"];
			
			return $ret;
		   }
		   
		   function appLogin($data)
		   {
			 //authenticate this login
            if($this->isValidUser($data))
            {
            	//Login successful               
               $user = Auth::user();          
			   $u = $this->getUser($user->id);
			   $ud = $u['data'];
			   /**
			   	$temp['fname'] = $u->fname; 
                       $temp['lname'] = $u->lname; 
                       $temp['phone'] = $u->phone; 
                       $temp['phone_status'] = $u->phone_status; 
                       $temp['email'] = $u->email; 
                       $temp['email_status'] = $u->email_status; 
                       $temp['role'] = $u->role; 
                       $temp['status'] = $u->status; 
                       $temp['type'] = $u->type; 
                       $temp['id'] = $u->id; 
                       $temp['tk'] = $u->tk; 
                       $temp['date'] = $u->created_at->format("jS F, Y h:i"); 
			   **/
			   $dt = [
			     'fname' => $u['fname'],
			     'lname' => $u['lname'],
			     'phone' => $u['phone'],
			     'email' => $u['email'],
			     'status' => $u['status'],
			     'type' => $u['type'],
			     'tk' => $u['tk'],
			     'img' => $ud['img'],
			     'gender' => $ud['gender']
			   ];
			   
			   /**
			   $products = $this->getProducts($user);
			   $customers = $this->getCustomers($user);
			   $sales = $this->getSales($user);
			   **/
			   
			   $ret = [
			     'status' => "ok",
				 'user' => $dt
				];
            }
			
			else
			{
				$ret = ['status' => "error",'message' => "Login failed, please contact support"];
			}
			
			return $ret;
		   }
		   
		    function checkNumber($num)
           {
           	$ret = ['status' => 'ok', 'exists' => false];
               $u = User::where('phone',$num)->first();
 
              if($u != null)
               {
                   	$ret['exists'] = true; 
               }                          
                                                      
                return $ret;
           }
		 
		 function addLocation($data)
           {
			   $u = User::where('email',$data['id'])->first();
                $ret = ['status' => "error", 'message' => "Invalid user"];
				
              if($u != null)
               {
				   $latlng = $data['lat'].",".$data['lng'];
				   
                   	$ret = Locations::create([
                                                      'user_id' => $u->id,
                                                      'latlng' => $latlng,
													  'fav' => $data['fav'], 
													  'address' => $data['address'], 
                                                      ]);
               }                                      
                return $ret;
           }
		   
		   
		   function getLocations($data)
           {
           	$ret = [];
              $locs = Locations::where('user_id',$data['user_id'])->get();
 
              if($locs != null)
               {
				  foreach($locs as $l)
				  {
					  $temp = [];
					  $temp['id'] = $l->id;
					  $temp['user_id'] = $l->user_id;
					  $temp['fav'] = $l->fav;
					  $temp['address'] = $l->address;
					  $temp['latlng'] = $l->latlng;
					  array_push($ret,$temp);
				  }
               }                         
                                                      
                return $ret;
           }
		   
		
		
           
           
}
?>