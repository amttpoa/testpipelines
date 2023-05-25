<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Organization;
use Illuminate\Http\Request;

class ScraperController extends Controller
{

    public function organizations()
    {

        return "scrape";
        // $crawler = Http::get('https://www.ohioattorneygeneral.gov/Law-Enforcement/Law-Enforcement-Directory/Printable-Law-Enforcement-Directory/Printable-Directory');
        // dd($crawler->getBody()->getContents());
        $crawler = \Weidner\Goutte\GoutteFacade::request('GET', 'https://www.ohioattorneygeneral.gov/Law-Enforcement/Law-Enforcement-Directory/Printable-Law-Enforcement-Directory/Printable-Directory');
        $crawler->filter('.lePrint')->each(function ($node) {
            $name = $node->filter('h2')->text();
            $leader = $node->filter('strong')->text();

            $full_address = $node->filter('td:first-of-type')->html();
            $address_array = explode('<br>', $full_address);
            $lines_count = count($address_array);
            $address2 = null;
            if ($lines_count == 3) {
                $address = Str::of($address_array[0])->trim();
                $city_line = Str::of($address_array[1])->trim();
                $county = Str::of($address_array[2])->trim();
            } else {
                $address = Str::of($address_array[0])->trim();
                $address2 = Str::of($address_array[1])->trim();
                $city_line = Str::of($address_array[2])->trim();
                $county = Str::of($address_array[3])->trim();
            }
            $city_array = explode(',', $city_line);
            $city = Str::of($city_array[0])->trim();
            $state_line = Str::of($city_array[1])->trim();
            $state_zrray = explode(' ', $state_line);

            $state = Str::of($state_zrray[0])->trim();
            $zip = Str::of($state_zrray[1])->trim();

            $numbers = $node->filter('td:nth-of-type(2)')->html();
            $numbers_array = explode('<br>', $numbers);
            // echo (count($numbers_array));
            // echo ('<br>');
            $email = null;
            $phone = null;
            $fax = null;
            foreach ($numbers_array as $line) {
                $line = Str::of($line)->trim();
                if (Str::contains($line, '@')) {
                    $email = $line;
                }
                if (Str::contains($line, 'Phone')) {
                    $phone = Str::replace('Phone number: ', '', $line);
                }
                if (Str::contains($line, 'Fax')) {
                    $fax = Str::replace('Fax number: ', '', $line);
                }
            }
            echo ($name);
            echo ('<br>');
            echo ($leader);
            echo ('<br>');
            echo ($address);
            echo ('<br>');
            echo ($address2);
            echo ('<br>');
            echo ($city);
            echo ('<br>');
            echo ($state);
            echo ('<br>');
            echo ($zip);
            echo ('<br>');
            echo ($county);
            echo ('<br>');
            echo ($phone);
            echo ('<br>');
            echo ($fax);
            echo ('<br>');
            echo ($email);
            echo ('<br>');
            $organization = Organization::where('name', $name)->first();
            // dd($organization);
            if ($organization) {
                echo ('Found');
                $organization->name = $name;
                $organization->leader = $leader;
                $organization->address = $address;
                $organization->address2 = $address2;
                $organization->city = $city;
                $organization->state = $state;
                $organization->zip = $zip;
                $organization->county = $county;
                $organization->phone = $phone;
                $organization->fax = $fax;
                $organization->email = $email;
                $organization->update();
            } else {
                echo ('NOT FOUND');
                $organization = new Organization();
                $organization->name = $name;
                $organization->leader = $leader;
                $organization->address = $address;
                $organization->address2 = $address2;
                $organization->city = $city;
                $organization->state = $state;
                $organization->zip = $zip;
                $organization->county = $county;
                $organization->phone = $phone;
                $organization->fax = $fax;
                $organization->email = $email;
                $organization->organization_type = 'Customer';
                $organization->save();
            }


            echo ('<br>');
            echo ('<hr>');
        });
        // return view('welcome');
    }
}
