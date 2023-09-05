<?php

namespace App\Controllers;
use App\Controllers\Controller;
use App\Models\User;
use Respect\Validation\Validator as v; 
use App\Models\Search;
use App\Models\State;
use App\Models\Country;

class SearchesController extends Controller{
	
	/**
	* List all searches
	* 
	* @return
	*/
	public function index($request, $response,  $args){

        //find all searches by the user with this ID
        if(isset($args['user_id'])){
            $searches = Search::where('user_id',$args['user_id'] )->get();
             //get the user's details
	          $user = User::find($args['user_id']);

              return $this->view->render($response,'searches/index.twig', ['searches'=>$searches, 'user'=>$user]);
        }else{
            $searches = Search::all();
            return $this->view->render($response,'searches/index.twig', ['searches'=>$searches]);
        }

	}



	/**
	* Display a search
	* 
	* @return
	*/
	public function view($request, $response, $args){
	
	    $searches = Search::find( $args['id']);
		
		return $this->view->render($response,'searches/view.twig', ['skill'=>$skill]);
		
	}


	
	/**
	* Create A New search
	* 
	* @return
	*/
	public function add($request, $response,  $args){
	
        if($request->isPost()){
           
            /**
            * validate input before submission
            * @var 
            * 
            */ 
            $validation = $this->validator->validate($request, [
                'searchterm' => v::notEmpty(),	
            ]);


		//redirect if validation fails
		if($validation->failed()){
			$this->flash->addMessage('error', 'Search Field Can not be Empty!'); 
		
			return $response->withRedirect($this->router->pathFor('searches/add.twig')); 
		}
		
            Search::firstOrCreate([
                'title' => $request->getParam('searchterm'),
                'user_id' => $this->auth->user()->id,
            ]);

                //$this->flash->addMessage('success', 'Search Added Successfully');
                //redirect to eg. searches/view/8 

				$searchTerm = $request->getParam('searchterm');
				$users = User::where('first_name', $searchTerm)->orwhere('email', $searchTerm)->get();
                return $this->view->render($response,'searches/add.twig', ['users'->$users, 'searchTerm'->$searchTerm]);
           
        }
		return $this->view->render($response,'searches/add.twig');
		
	}
}