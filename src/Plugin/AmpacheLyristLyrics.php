<?php

/**
 * vim:set softtabstop=4 shiftwidth=4 expandtab:
 *
 * LICENSE: GNU Affero General Public License, version 3 (AGPL-3.0-or-later)
 * Copyright Ampache.org, 2001-2023
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 *
 */
declare(strict_types=0);

namespace Ampache\Plugin;

use Ampache\Repository\Model\Preference;
use Ampache\Repository\Model\Song;
use Ampache\Repository\Model\User;
use Ampache\Module\System\Core;
use WpOrg\Requests\Requests;

class AmpacheLyristLyrics implements AmpachePluginInterface
{
    public string $name        = 'Lyrist Lyrics';
    public string $categories  = 'lyrics';
    public string $description = 'Get lyrics from a public Lyrist instance';
    public string $url         = 'https://github.com/asrvd/lyrist';
    public string $version     = '000002';
    public string $min_ampache = '360022';
    public string $max_ampache = '999999';

    // These are internal settings used by this class, run this->load to fill them out
    private string $api_host;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->description = T_('Get lyrics from a public Lyrist instance');
    }

    /**
     * install
     * This is a required plugin function
     */
    public function install(): bool
    {
        if (!Preference::exists('lyrist_api_url') && !Preference::insert('lyrist_api_url', T_('Lyrist API URL'), '', 25, 'string', 'plugins', $this->name)) {
            return false;
        }

        return true;
    }

    /**
     * uninstall
     * This is a required plugin function
     */
    public function uninstall(): bool
    {
        return true;
    }

    /**
     * upgrade
     * This is a recommended plugin function
     */
    public function upgrade(): bool
    {
        return true;
    }

    /**
     * load
     * This is a required plugin function; here it populates the prefs we
     * need for this object.
     * @param User $user
     */
    public function load($user): bool
    {
        $user->set_preferences();
        $data = $user->prefs;
        // check if user have a token
        if (strlen(trim($data['lyrist_api_url']))) {
            $this->api_host = trim($data['lyrist_api_url']);
        } else {
            debug_event('lyrist.plugin', 'No url (need to add your Lyrist host to ampache)', 4);

            return false;
        }

        return true;
    }

    /**
     * get_lyrics
     * This will look web services for a song lyrics.
     * @param Song $song
     * @return array|false
     */
    public function get_lyrics($song)
    {
        $uri     = rtrim(preg_replace('/\/api\/?/', '', $this->api_host), '/') . '/api/' . urlencode((string)$song->title) . '/' . urlencode((string)$song->get_artist_fullname());
        $request = Requests::get($uri, array(), Core::requests_options());
        if ($request->status_code == 200) {
            $json = json_decode($request->body);
            if ($json) {
                if (!empty($json->lyrics)) {
                    return array(
                        'text' => nl2br($json->lyrics),
                        'url' => $json->image
                    );
                }
            }
        }

        return false;
    }
}
