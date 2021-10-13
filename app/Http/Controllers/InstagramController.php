<?php

namespace App\Http\Controllers;

use Phpfastcache\Helper\Psr16Adapter;
use Phpfastcache\Config\Config;
use InstagramScraper\Instagram;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use InstagramScraper\Exception\InstagramNotFoundException;
use InstagramScraper\Exception\InstagramException;
use GuzzleHttp\Exception\ConnectException;
use ErrorException;
use RequestException;
use InstagramScraper\Exception\InstagramAuthException;
use Illuminate\Http\Request;

class InstagramController extends Controller
{

    public function index(Request $request)
    {
       
            
        // $instagram = \InstagramScraper\Instagram::withCredentials(new \GuzzleHttp\Client(), 'chec.k846', 'Praveen7041', new Psr16Adapter('Files'));
        // $instagram->login(); // will use cached session if you want to force login $instagram->login(true)
        // $instagram->saveSession();  //DO NOT forget this in order to save the session, otherwise have no sense

        // $username = $request->name;
        // $account = $instagram->getAccount($username);
        // $response = $instagram->getPaginateMedias($username);
        // $medias = $instagram->getMedias($username, 12);

    

            // $r=0;
            // $f=0;

            // foreach ($medias as $media) {
            //     /** @var \InstagramScraper\Model\Media $media */
            
            //     $r = $r + $media->getLikesCount();
            //     $f = $f + $media->getCommentsCount();
            
            //     // echo "Number of comments: {$media->getCommentsCount()}" . PHP_EOL;
            //     //  echo "Number of likes: {$media->getLikesCount()}" . PHP_EOL;

            
            // }

                //  $follow= $account->getFollowsCount() ; 

            // echo "Username: {$account->getUsername()}\n";
            // echo "Number of published posts: {$account->getMediaCount()}\n";
            // echo "Number of following: {$account->getFollowsCount()}\n";
            // echo "Number of followers: {$account->getFollowedByCount()}\n";
            // echo "Is private: {$account->isPrivate()}\n";
            // echo "Is verified: {$account->isVerified()}\n";


            // $l = round($r / 12,2);
            // echo "Average Likes : {$l}";
            

            // $c = round($f / 12,2) ;
            // echo "Average Comments :{$c}";
            

            // if($account->getFollowedByCount() > 0)
            // {
            //     $e = ( ($l + $c) / $account->getFollowedByCount() ) * 100 ;

            //     echo "Eng.Rate  :";
            // echo round($e,2);
                
            // }
            // if($account->getFollowsCount() == 0)
            // {
            //     echo "Eng.Rate  : 0";   
            // }
           
        
      
        return view('welcome');
    }
    public function data(Request $request)
    {

      
        try {
        
           
            // $config = new Config();
            // $config->setDefaultTtl(99999999999999999999999999999); //default ttl in seconds, should be as long as instagram login stays valid (don't know how long this is)
        $instagram = \InstagramScraper\Instagram::withCredentials(new \GuzzleHttp\Client(), 'chec.k846', 'Praveen7041', null);
        // $instagram->login(); // will use cached session if you want to force login $instagram->login(true)
        // $instagram->saveSession();  //DO NOT forget this in order to save the session, otherwise have no sense
        
        $instagram->loginWithSessionId('9234466429%3ARW5oece5M5jj7H%3A10'); 
        // $instagram->saveSession();

        $username = $request->name;
        $account = $instagram->getAccount($username);
        $response = $instagram->getPaginateMedias($username);
        $medias = $instagram->getMedias($username, 12);

         $bio= $account->getBiography() ; 
         $user =$account->getUsername();
         $fname = $account->getFullName();
         $purl = $account->getProfilePicUrl(); 
         $check = $account->isVerified();
         $private = $account->isPrivate();
         
         

            $r=0;
            $f=0;

            foreach ($medias as $media) {
                /** @var \InstagramScraper\Model\Media $media */
            
                $r = $r + $media->getLikesCount();
                $f = $f + $media->getCommentsCount();
            
                // $image = $media->getImageHighResolutionUrl();
                // echo "Number of comments: {$media->getCommentsCount()}" . PHP_EOL;
                //  echo "Number of likes: {$media->getLikesCount()}" . PHP_EOL;

            
            }

            $following= $account->getFollowsCount() ; 
            $post= $account->getMediaCount() ; 
            $followers= $account->getFollowedByCount() ; 

            if($account->getMediaCount() < 12)
            {
                $l = round($r / $account->getMediaCount(),2);
                $avglikes = $l;
                
    
                $c = round($f / $account->getMediaCount(),2) ;
                $avgcomments = $c;
            }
            if($account->getMediaCount() >= 12)
            {
                $l = round($r / 12,2);
                $avglikes = $l;
                
    
                $c = round($f / 12,2) ;
                $avgcomments = $c;
            }

          
            

            if($account->getFollowedByCount() > 0)
            {
                $e = ( ($l + $c) / $account->getFollowedByCount() ) * 100 ;

            
            $engrate = round($e,2);
                
            }
            if($account->getFollowsCount() == 0)
            {
                $engrate = '0';
            }

            return view('instagram',['followers'=>$followers,'following'=>$following,'engrate'=>$engrate,'avglikes'=>$avglikes,
            'avgcomments'=>$avgcomments,'post'=>$post,'bio'=>$bio,'user'=>$user,'fname'=>$fname,
            'purl'=>$purl,'check'=>$check,'private'=>$private]);

    }

            catch (InstagramAuthException  $exception) {

            return back()->withError($request->session()->flash('status', 'Something Went Wrong ! Try Again Later'));
            
        }
                catch (RequestException  $exception) {

                    // echo "ERROR 111";
                
                return back()->withError($request->session()->flash('status', 'Something Went Wrong ! Try Again Later'));
                
            }
            catch (ErrorException  $exception) {

            return back()->withError($request->session()->flash('status', 'Something Went Wrong ! Try Again '));
            // $request->session()->flash('status', 'Unsuccesfully');

            
        } 
            catch (InstagramException  $exception) {

            return back()->withError($request->session()->flash('status', 'Something broke on our end, please try again!'));
            // $request->session()->flash('status', 'Unsuccesfully');
        
            
        } 
        catch (ConnectException  $exception) {

            // echo "ERROR 111";
        //  $request->session()->flash('status', 'Added Succesfully');
        return back()->withError($request->session()->flash('status', 'Something broke on our end, please try again!'));
        // $request->session()->flash('status', 'Unsuccesfully');
    
        
    } 
            catch (InstagramNotFoundException  $exception) {
                return back()->withError($request->session()->flash('status', 'Could not find a user ! Please try another user.'));
                //  echo "ERROR 222";
                // $request->session()->flash('status', 'Added Succesfully');
                //  $request->session()->flash('status', 'Unsuccesfully');
                // return redirect('/');
                
            } 
     
     }
   
}
