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

class User
{
    public static function GenerateUserList($site, $response)
    {
        $users_html = array();
        
        while($user = $response->Fetch(FALSE))
        {
            // Get the user's location
            if(!isset($user['location']))
                $user['location'] = '<span class="unknown">[unknown]</span>';
            
            // Generate the URL of their profile
            $profile_url = ViewUtils::GetDocumentRoot() . "/{$site['site']['api_site_parameter']}/users/{$user['user_id']}";
            
            $users_html[] = "<li><a href='$profile_url'><img src='{$user['profile_image']}&s=16' class='site-icon ui-li-icon' />{$user['display_name']}<p>{$user['location']}</p></a></li>";
        }
        
        return implode('', $users_html);
    }
}

?>