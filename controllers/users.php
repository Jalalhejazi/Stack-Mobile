<?php

/* Stack Mobile - Bringing Stack Exchange Sites to Mobile Devices
   Copyright (C) 2012  Nathan Osman

   This program is free software: you can redistribute it and/or modify
   it under the terms of the GNU General Public License as published by
   the Free Software Foundation, either version 3 of the License, or
   (at your option) any later version.

   This program is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU General Public License for more details.

   You should have received a copy of the GNU General Public License
   along with this program.  If not, see <http://www.gnu.org/licenses/>. */

require_once 'internal/base_controller.php';
require_once 'internal/api.php';

class UsersController extends BaseController
{
    public function index($site)
    {
        $this->SetPageInfo('Users on {name}', '{url}/users', $site);
        
        // Check for a page number
        $page = $this->GetGETVariable('page', 1);
        
        // Retrieve the user list for the site
        $this->SetViewVariable('response', API::Site($site)->Users()->Filter('!-q2Rj6nE')->Exec()->Page($page));
        $this->SetViewVariable('page',     $page);
    }
    
    public function view($site, $id)
    {
        // Fetch the user's profile
        $user = API::Site($site)->Users($id)->Filter('!-psgDpsh')->Exec()->Fetch();
        
        if($user === FALSE)
            throw new Exception("The user with ID #$id does not exist.");
        
        $this->SetPageInfo('User ' . $user['display_name'], '{url}/users/' . $user['user_id'], $site);
        
        // Now fetch the user's top 5 questions
        $questions = API::Site($site)->Users($id)->Questions()->Filter('!-psgAvQU')->Exec()->Pagesize(5);
        
        // ...and their top 5 answers
        $answers = API::Site($site)->Users($id)->Answers()->Filter('!9SwXE.JQY')->Exec()->Pagesize(5);
        
        $this->SetViewVariable('user',      $user);
        $this->SetViewVariable('questions', $questions);
        $this->SetViewVariable('answers',   $answers);
    }
}

?>