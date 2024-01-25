<?php

use App\Leave;
use App\Setting;
use Darryldecode\Cart\Cart;
use Illuminate\Support\Facades\Gate;
use Twilio\Rest\Client;

use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use LaravelFCM\Facades\FCM;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Models\Permission;
use App\Category;
use App\Brand;
use App\Models\Role;
use App\Attachment;
use App\Models\RolePermission;
use App\Models\User;
use App\ProjectUser;
use App\TeamMembers;
use App\Team;
use App\Profile;
use App\Notification;
use App\Message;
use App\LeadSource;
use App\Service;
use App\DailyCompaign;
use App\Lead;
use App\Disposition;
use App\Country;
use App\City;
use App\CustomerContact;
use App\Customer;
use App\TaskUser;
use App\Categories;
use App\Menuitem;
use App\Menu;
use App\Testimonial;
use App\TeamPage;
use App\Portfolio;
use App\Post;
use App\CustomSection;
use App\Banner;
use App\PortfolioCategory;
use App\ServiceCategory;
use App\PostCategories;
use App\BlogComments;
use App\Page;
use App\Product;
use App\ProductVariant;
use App\ProductColor;
use App\ProductSize;


function required()
{
    return ' <span class="required">*</span>';
}

function metricsName($value)
{
    return ucwords(ucfirst(str_replace('_', ' ', $value)));
}

if (!function_exists('formatDate')) {
    function formatDate($value)
    {
        return Carbon::parse($value)->format('d M Y');
    }
}

if (!function_exists('formatTime')) {
    function formatTime($value)
    {
        return Carbon::parse($value)->format('h:i a');
    }
}

if (! function_exists('getUserPurchaseGalleries')){
    function getUserPurchaseGalleries($value){
        if($value == 'gallery'){
            return \App\UserPurchase::where('purchase_type', 'gallery')->where('user_id', auth()->user()->id)->pluck('gallery_id')->toArray();
        }
        else {
            return \App\UserPurchase::where('purchase_type', 'video')->where('user_id', auth()->user()->id)->pluck('video_id')->toArray();
        }
    }
}

if (!function_exists('getUserDetail')) {
    function getUserDetail($value)
    {
        return User::where('id', $value)->first();
//        return User::with('role')->where('id', $value)->first();
    }
}

if (!function_exists('getUserByType')) {
    function getUserByType($value)
    {
        return User::where('status', '1')->whereIn('user_type', $value)->pluck('name', 'id')->toArray();
    }
}

if (!function_exists('getAllCustomers')) {
    function getAllCustomers()
    {
        $CustomerContact = CustomerContact::select(
            DB::raw("CONCAT(first_name,' ',last_name) AS name"), 'customer_id')
            ->where('status', 1)->where('is_primary', 1)
            ->pluck('name', 'customer_id')->toArray();

        return $CustomerContact;
        return Customer::where('status', 1)->pluck('company', 'id')->toArray();
    }
}

if (!function_exists('getAllProfiles')) {
    function getAllProfiles()
    {
        return Profile::pluck('name', 'id')->toArray();
    }
}

if (!function_exists('getAllMembers')) {
    function getAllMembers()
    {
        return User::where('user_type', '!=', 2)->where('user_type', '!=', 0)->pluck('name', 'id')->toArray();
    }
}

if (!function_exists('getTeamMembers')) {
    function getTeamMembers($team_id)
    {
        return TeamMembers::where('team_id', $team_id)->where('is_lead', 0)->pluck('member_id')->toArray();
    }
}

if (!function_exists('getTeamLead')) {
    function getTeamLead($team_id)
    {
        $team_member = TeamMembers::with('team_lead')->where('team_id', $team_id)->where('is_lead', 1)->first();
        if (!is_null($team_member)) {
            return $team_member->toArray();
        }
        return null;
    }
}

if (!function_exists('getProjectMembers')) {
    function getProjectMembers($project_id)
    {
        return ProjectUser::where('project_id', $project_id)->pluck('member_id')->toArray();
    }
}

if (!function_exists('getTeamName')) {
    function getTeamName($team_id)
    {
        return Team::where('id', $team_id)->first();
    }
}

if (!function_exists('getAmountFormat')) {
    function getAmountFormat($value)
    {
        if ($value) {
            return '<span class="currenct currency-usd">Rs. </span>' . number_format("$value", 2);
        }
    }
}


if (!function_exists('getBrandName')) {
    function getBrandName($value)
    {

        return Brand::where('id', $value)->pluck('name')->first();
    }
}

if (!function_exists('getRoleName')) {
    function getRoleName($value)
    {
        return Role::where('id', $value)->pluck('name')->first();
    }
}

if (!function_exists('getUserPermissions')) {

    function getUserPermissions()
    {
        if (auth()->user()->role_id != 0) {
           // dd(RolePermission::where('role_id', auth()->user()->role_id)->pluck('permission_id')->toArray());
            return RolePermission::where('role_id', auth()->user()->role_id)->pluck('permission_id')->toArray();
        } else {
            return Permission::pluck('name')->toArray();
        }
    }
}

function checkPermission($value)
{
   // dd($value);
    if (auth()->user()->role_id != 0) {
        //dd('dd');
        if (!in_array($value, getUserPermissions())) {
            return abort('403');
        }
    }
}

if (!function_exists('hasUnreadMessages')) {
    function hasUnreadMessages()
    {
        $count = Message::getUnreadCount();
        if ($count > 0) {
            return true;
        }
        return false;
    }
}


function getHrsMins($time)
{
    $hours = floor($time / 60);
    $minutes = ((($time * 60) + $time) % 60);
    if ($minutes > 0) {
        return $hours . 'h ' . $minutes . 'm';
    } else {
        return $hours . 'h ';
    }

}

function getHrsMinsArray($time)
{
    return [
        'time_hrs' => floor($time / 60),
        'time_mins' => ((($time * 60) + $time) % 60)
    ];
}

function getNotifyTime($time)
{
    $notifyTime = Carbon::parse($time)->diffForHumans();
    return $notifyTime;
}

function getNotifyCount()
{
    $count = 0;
    foreach (auth()->user()->notifications as $key => $notification) {
        if (is_null($notification->read_at)) {
            $count++;
        }
    }
    return $count;
}

function daysLeft($date)
{
    if ($date) {
        $remaining_days = Carbon::now()->diffInDays(Carbon::parse($date));
    } else {
        $remaining_days = 0;
    }


    if ($remaining_days >= 10) {
        return '<span class="badge badge-dim badge-light text-gray"><em class="icon ni ni-clock"></em><span>' . $remaining_days . ' Days Left</span></span>';
    } elseif ($remaining_days >= 2 && $remaining_days <= 9) {
        return '<span class="badge badge-dim badge-warning"><em class="icon ni ni-clock"></em><span>' . $remaining_days . ' Days Left</span></span>';
    } else {
        return '<span class="badge badge-dim badge-danger"><em class="icon ni ni-clock"></em><span>' . $remaining_days . ' Day Left</span></span>';
    }
}

if (!function_exists('getFiles')) {
    function getFiles($attachment_id)
    {
        $file_ids = explode(',', $attachment_id);
        $attachments = Attachment::whereIn('id', $file_ids)->get();
        $html = '<div class="attach-files"><ul class="attach-list">';
        foreach ($attachments as $attachment) {
            $exploded = explode('.', $attachment->name);
            $file_name = substr($attachment->name, 0, strrpos($attachment->name, "."));
            $file_ext = strtolower(end($exploded));
            if ($file_ext == 'png') {
                $html .= '<li class="attach-item" data-toggle="tooltip" data-placement="top" title="' . $file_name . '"><a class="download" target="_blank" href="' . asset('attachments/' . $attachment->name) . '"><img src="' . asset('images/icons/PNG.png') . '" width="35px"><span> &nbsp;' . $file_name . '</span></a></></li>';
            } elseif ($file_ext == 'jpg' || $file_ext == 'jpeg') {
                $html .= '<li class="attach-item" data-toggle="tooltip" data-placement="top" title="' . $file_name . '"><a class="download" target="_blank" href="' . asset('attachments/' . $attachment->name) . '"><img src="' . asset('images/icons/JPEG.png') . '" width="35px"><span> &nbsp;' . $file_name . '</span></a></></li>';
            } elseif ($file_ext == 'svg') {
                $html .= '<li class="attach-item" data-toggle="tooltip" data-placement="top" title="' . $file_name . '"><a class="download" target="_blank" href="' . asset('attachments/' . $attachment->name) . '"><img src="' . asset('images/icons/SVG.png') . '" width="35px"><span> &nbsp;' . $file_name . '</span></a></></li>';
            } elseif ($file_ext == 'psd') {
                $html .= '<li class="attach-item" data-toggle="tooltip" data-placement="top" title="' . $file_name . '"><a class="download" target="_blank" href="' . asset('attachments/' . $attachment->name) . '"><img src="' . asset('images/icons/DOC.png') . '" width="35px"><span> &nbsp;' . $file_name . '</span></a></></li>';
            } elseif ($file_ext == 'ai') {
                $html .= '<li class="attach-item" data-toggle="tooltip" data-placement="top" title="' . $file_name . '"><a class="download" target="_blank" href="' . asset('attachments/' . $attachment->name) . '"><img src="' . asset('images/icons/AI.png') . '" width="35px"><span> &nbsp;' . $file_name . '</span></a></></li>';
            } elseif ($file_ext == 'eps') {
                $html .= '<li class="attach-item" data-toggle="tooltip" data-placement="top" title="' . $file_name . '"><a class="download" target="_blank" href="' . asset('attachments/' . $attachment->name) . '"><img src="' . asset('images/icons/EPS.png') . '" width="35px"><span> &nbsp;' . $file_name . '</span></a></></li>';
            } elseif ($file_ext == 'pdf') {
                $html .= '<li class="attach-item" data-toggle="tooltip" data-placement="top" title="' . $file_name . '"><a class="download" target="_blank" href="' . asset('attachments/' . $attachment->name) . '"><img src="' . asset('images/icons/PDF.png') . '" width="35px"><span> &nbsp;' . $file_name . '</span></a></></li>';
            } elseif ($file_ext == 'zip') {
                $html .= '<li class="attach-item" data-toggle="tooltip" data-placement="top" title="' . $file_name . '"><a class="download" target="_blank" href="' . asset('attachments/' . $attachment->name) . '"><img src="' . asset('images/icons/ZIP.png') . '" width="35px"><span> &nbsp;' . $file_name . '</span></a></></li>';
            } elseif ($file_ext == 'rar') {
                $html .= '<li class="attach-item" data-toggle="tooltip" data-placement="top" title="' . $file_name . '"><a class="download" target="_blank" href="' . asset('attachments/' . $attachment->name) . '"><img src="' . asset('images/icons/RAR.png') . '" width="35px"><span> &nbsp;' . $file_name . '</span></a></></li>';
            } elseif ($file_ext == 'ppt' || $file_ext == 'pptx') {
                $html .= '<li class="attach-item" data-toggle="tooltip" data-placement="top" title="' . $file_name . '"><a class="download" target="_blank" href="' . asset('attachments/' . $attachment->name) . '"><img src="' . asset('images/icons/PPTX.png') . '" width="35px"><span> &nbsp;' . $file_name . '</span></a></></li>';
            } elseif ($file_ext == 'doc' || $file_ext == 'docx') {
                $html .= '<li class="attach-item" data-toggle="tooltip" data-placement="top" title="' . $file_name . '"><a class="download" target="_blank" href="' . asset('attachments/' . $attachment->name) . '"><img src="' . asset('images/icons/DOC.png') . '" width="35px"><span> &nbsp;' . $file_name . '</span></a></></li>';
            } elseif ($file_ext == 'txt') {
                $html .= '<li class="attach-item" data-toggle="tooltip" data-placement="top" title="' . $file_name . '"><a class="download" target="_blank" href="' . asset('attachments/' . $attachment->name) . '"><img src="' . asset('images/icons/TXT.png') . '" width="35px"><span> &nbsp;' . $file_name . '</span></a></></li>';
            } else {
                $html .= '<li class="attach-item" data-toggle="tooltip" data-placement="top" title="' . $file_name . '"><a class="download" target="_blank" href="' . asset('attachments/' . $attachment->name) . '"><img src="' . asset('images/icons/FILE.png') . '" width="35px"><span> &nbsp;' . $file_name . '</span></a></></li>';
            }

        }
        $html .= '</ul></div>';
        return $html;
    }
}

if (!function_exists('sendNotification')) {
    function sendNotification($description, $link, $member_id, $user_id)
    {
        Notification::create([
            'description' => $description,
            'link' => $link,
            'member_id' => $member_id,
            'user_id' => $user_id
        ]);
    }
}

function priceToFloat($s)
{
    // convert "," to "."
    $s = str_replace(',', '.', $s);

    // remove everything except numbers and dot "."
    $s = preg_replace("/[^0-9\.]/", "", $s);

    // remove all seperators from first part and keep the end
    $s = str_replace('.', '', substr($s, 0, -3)) . substr($s, -3);

    // return float
    return (float)$s;
}

function jsonClean($json)
{
    $str_response = mb_convert_encoding($json, 'utf-8', 'auto');

    for ($i = 0; $i <= 31; ++$i) {
        $str_response = str_replace(chr($i), "", $str_response);
    }
    $str_response = str_replace(chr(127), "", $str_response);

    if (0 === strpos(bin2hex($str_response), 'efbbbf')) {
        $str_response = substr($str_response, 3);
    }

    return $str_response;
}

function monthAlpha($value)
{
    switch ($value) {
        case 1:
            return 'January';
            break;
        case 2:
            return 'February';
            break;
        case 3:
            return 'March';
            break;
        case 4:
            return 'April';
            break;
        case 5:
            return 'May';
            break;
        case 6:
            return 'June';
            break;
        case 7:
            return 'July';
            break;
        case 8:
            return 'August';
            break;
        case 9:
            return 'September';
            break;
        case 10:
            return 'October';
            break;
        case 11:
            return 'November';
            break;
        case 12:
            return 'December';
            break;
    }
}

function hasPermission($permission_name)
{
    return \Auth::user()->user_type == \App\User::SUPER_ADMIN ?: \Auth::user()->can($permission_name);
}


function authenticateCustomer($apiToken)
{
    $parts = explode('-', $apiToken);
    $customerId = $parts[0];
    $customer =  \App\Models\Customer::find($customerId);
    return $customer;
}

function userStatus($value)
{
    switch ($value) {
        case 0:
            return '<label class="badge badge-info">No Check</label>';
            break;
        case 1:
            return '<label class="badge badge-danger">Failed</label>';
            break;
        case 2:
            return '<label class="badge badge-success">Passed</label>';
            break;
        case 3:
            return '<label class="badge badge-warning">Temperature Failed</label>';
            break;
        case 4:
            return '<label class="badge badge-warning">Covid Positive</label>';
            break;
    }
}

function getNameInitials($name)
{
    $nameParts = explode(' ', trim($name));
    $firstName = array_shift($nameParts);
    $lastName = array_pop($nameParts);
    $initials = mb_substr($firstName, 0, 1) . mb_substr($lastName, 0, 1);
    return strtoupper($initials);
}

function getUserImage($id)
{
    $user = getUserDetail($id);
//    if (isset($user->id)) {
//        if (Cache::has('user-is-online-' . $user->id)) {
//            echo '<div class="status dot dot-lg dot-success"></div>';
//        } else {
//            echo '<div class="status dot dot-lg dot-gray"></div>';
//        }
//    }

    if (isset($user->profile_picture)) {
        return '<img src="' . asset($user->profile_picture) . '">';
    } else {
        if (isset($user->name)) {
            $nameParts = explode(' ', trim($user->name));
            $firstName = array_shift($nameParts);
            $lastName = array_pop($nameParts);
            $initials = mb_substr($firstName, 0, 1) . mb_substr($lastName, 0, 1);
            return '<div class="avatar"><span class="avatar-title rounded-circle border border-white">'.strtoupper($initials).'</span></div>';

        }
    }

}

function isSuperAdmin()
{
    return intval(auth()->user()->application_id) === 0;
}

function isAdmin()
{
    return ( auth()->user()->user_type == 0 || auth()->user()->user_type == 1 ) ? true : false;
}

function sendEmail($dynamicData, $obj, $files = null)
{
    try {

        Mail::send('emails.payment_success', $obj, function ($message) use ($dynamicData, $obj, $files) {
            $message->setFrom($obj["from"], $obj["sales"]);
            $message->setSubject($obj["subject"]);
            $message->addTo($obj["to"], $obj["customer"]);
            $message->attach(public_path('/temp_files/') . $files['fileName']);
        });

    } catch (Exception $e) {
        echo 'Caught exception: ' . $e->getMessage() . "\n";
    }
}

function getWorkingHours($in, $out)
{

    $ts1 = strtotime(str_replace('/', '-', date('H:i:s', strtotime($in))));
    $ts2 = strtotime(str_replace('/', '-', $out));
    return abs($ts1 - $ts2) / 3600;

}


function getWorkingHoursSheet($in, $out)
{
    $startTime = Carbon::parse($in);
    $finishTime = Carbon::parse($out);

    $totalDuration = $finishTime->diffInSeconds($startTime);
    return gmdate('H:i:s', $totalDuration);
}

function getTimeTotal($in, $out)
{
    $startTime = Carbon::parse($in);
    $finishTime = Carbon::parse($out);

    $totalDuration = $finishTime->diffInMinutes($startTime);
    return $totalDuration;
}

function getProfileJss($id)
{
    return \App\ProfileJss::where('profile_id', $id)->pluck('jss_record')->last();
}

function getProfileName($id)
{
    return Profile::where('id', $id)->pluck('name')->first();
}

function getUserAvailedLeaves($id)
{
    return Leave::where(['user_id' => $id, 'status' => 2])->pluck('no_of_days')->sum();
}

function getUserAppliedLeaves($id)
{
    return Leave::where(['user_id' => $id, 'status' => 0])->pluck('no_of_days')->sum();
}


if (!function_exists('getLeadSourceName')) {
    function getLeadSourceName($value)
    {
        return LeadSource::where('id', $value)->pluck('name')->first();
    }
}

if (!function_exists('getServiceName')) {
    function getServiceName($value)
    {
        return Service::where('id', $value)->pluck('name')->first();
    }
}

if (!function_exists('getCompaignTotal')) {
    function getCompaignTotal($date, $service_id, $lead_source_id)
    {
        $dailyCompaign = DailyCompaign::where('date', $date)->where('service_id', $service_id)->where('lead_source_id', $lead_source_id)->get();
        return $dailyCompaign->sum('amount');
    }
}

if (!function_exists('getLeadConversionTotal')) {
    function getLeadConversionTotal($date, $service_id, $lead_source_id)
    {
        $lead = Lead::where('date', $date)->where('service_id', $service_id)->where('lead_source_id', $lead_source_id)->where('status', 2)->get();
        // dump($lead->sum('amount'));
        return $lead->count('status');
    }
}

if (!function_exists('getLeadConversionRevenueTotal')) {
    function getLeadConversionRevenueTotal($date, $service_id, $lead_source_id)
    {
        $lead = Lead::where('date', $date)->where('service_id', $service_id)->where('lead_source_id', $lead_source_id)->where('status', 2)->get();
        // dump($lead->sum('amount'));
        return $lead->sum('amount');
    }
}

// if (!function_exists('getCountriesList')) {
//     function getCountriesList()
//     {
//         $country = Country::where('status', '1')->get();
//         // dd($country);
//         // $country = array(
//         //     "UK" => "United Kingdom",
//         //     "US" => "United States",
//         //     "AU" => "Australia",
//         //     "AF" => "Afghanistan",
//         //     "AL" => "Albania",
//         //     "DZ" => "Algeria",
//         //     "AS" => "American Samoa",
//         //     "AD" => "Andorra",
//         //     "AO" => "Angola",
//         //     "AI" => "Anguilla",
//         //     "AQ" => "Antarctica",
//         //     "AG" => "Antigua and Barbuda",
//         //     "AR" => "Argentina",
//         //     "AM" => "Armenia",
//         //     "AW" => "Aruba",
//         //     "AT" => "Austria",
//         //     "AZ" => "Azerbaijan",
//         //     "BS" => "Bahamas",
//         //     "BH" => "Bahrain",
//         //     "BD" => "Bangladesh",
//         //     "BB" => "Barbados",
//         //     "BY" => "Belarus",
//         //     "BE" => "Belgium",
//         //     "BZ" => "Belize",
//         //     "BJ" => "Benin",
//         //     "BM" => "Bermuda",
//         //     "BT" => "Bhutan",
//         //     "BO" => "Bolivia",
//         //     "BA" => "Bosnia and Herzegovina",
//         //     "BW" => "Botswana",
//         //     "BR" => "Brazil",
//         //     "BN" => "Brunei Darussalam",
//         //     "BG" => "Bulgaria",
//         //     "BF" => "Burkina Faso",
//         //     "BI" => "Burundi",
//         //     "KH" => "Cambodia",
//         //     "CM" => "Cameroon",
//         //     "CA" => "Canada",
//         //     "CV" => "Cape Verde",
//         //     "KY" => "Cayman Islands",
//         //     "CF" => "Central African Republic",
//         //     "TD" => "Chad",
//         //     "CL" => "Chile",
//         //     "CN" => "China",
//         //     "CX" => "Christmas Island",
//         //     "CC" => "Cocos (Keeling) Islands",
//         //     "CO" => "Colombia",
//         //     "KM" => "Comoros",
//         //     "CG" => "Congo",
//         //     "CD" => "Congo, The Democratic Republic of the",
//         //     "CK" => "Cook Islands",
//         //     "CR" => "Costa Rica",
//         //     "CI" => "Cote D`Ivoire",
//         //     "HR" => "Croatia",
//         //     "CY" => "Cyprus",
//         //     "CZ" => "Czech Republic",
//         //     "DK" => "Denmark",
//         //     "DJ" => "Djibouti",
//         //     "DM" => "Dominica",
//         //     "DO" => "Dominican Republic",
//         //     "EC" => "Ecuador",
//         //     "EG" => "Egypt",
//         //     "SV" => "El Salvador",
//         //     "GQ" => "Equatorial Guinea",
//         //     "ER" => "Eritrea",
//         //     "EE" => "Estonia",
//         //     "ET" => "Ethiopia",
//         //     "FK" => "Falkland Islands (Malvinas)",
//         //     "FO" => "Faroe Islands",
//         //     "FJ" => "Fiji",
//         //     "FI" => "Finland",
//         //     "FR" => "France",
//         //     "GF" => "French Guiana",
//         //     "PF" => "French Polynesia",
//         //     "GA" => "Gabon",
//         //     "GM" => "Gambia",
//         //     "GE" => "Georgia",
//         //     "DE" => "Germany",
//         //     "GH" => "Ghana",
//         //     "GI" => "Gibraltar",
//         //     "GR" => "Greece",
//         //     "GL" => "Greenland",
//         //     "GD" => "Grenada",
//         //     "GP" => "Guadeloupe",
//         //     "GU" => "Guam",
//         //     "GT" => "Guatemala",
//         //     "GN" => "Guinea",
//         //     "GW" => "Guinea-Bissau",
//         //     "GY" => "Guyana",
//         //     "HT" => "Haiti",
//         //     "HN" => "Honduras",
//         //     "HK" => "Hong Kong",
//         //     "HU" => "Hungary",
//         //     "IS" => "Iceland",
//         //     "IN" => "India",
//         //     "ID" => "Indonesia",
//         //     "IR" => "Iran (Islamic Republic Of)",
//         //     "IQ" => "Iraq",
//         //     "IE" => "Ireland",
//         //     "IL" => "Israel",
//         //     "IT" => "Italy",
//         //     "JM" => "Jamaica",
//         //     "JP" => "Japan",
//         //     "JO" => "Jordan",
//         //     "KZ" => "Kazakhstan",
//         //     "KE" => "Kenya",
//         //     "KI" => "Kiribati",
//         //     "KP" => "Korea North",
//         //     "KR" => "Korea South",
//         //     "KW" => "Kuwait",
//         //     "KG" => "Kyrgyzstan",
//         //     "LA" => "Laos",
//         //     "LV" => "Latvia",
//         //     "LB" => "Lebanon",
//         //     "LS" => "Lesotho",
//         //     "LR" => "Liberia",
//         //     "LI" => "Liechtenstein",
//         //     "LT" => "Lithuania",
//         //     "LU" => "Luxembourg",
//         //     "MO" => "Macau",
//         //     "MK" => "Macedonia",
//         //     "MG" => "Madagascar",
//         //     "MW" => "Malawi",
//         //     "MY" => "Malaysia",
//         //     "MV" => "Maldives",
//         //     "ML" => "Mali",
//         //     "MT" => "Malta",
//         //     "MH" => "Marshall Islands",
//         //     "MQ" => "Martinique",
//         //     "MR" => "Mauritania",
//         //     "MU" => "Mauritius",
//         //     "MX" => "Mexico",
//         //     "FM" => "Micronesia",
//         //     "MD" => "Moldova",
//         //     "MC" => "Monaco",
//         //     "MN" => "Mongolia",
//         //     "MS" => "Montserrat",
//         //     "MA" => "Morocco",
//         //     "MZ" => "Mozambique",
//         //     "NA" => "Namibia",
//         //     "NP" => "Nepal",
//         //     "NL" => "Netherlands",
//         //     "AN" => "Netherlands Antilles",
//         //     "NC" => "New Caledonia",
//         //     "NZ" => "New Zealand",
//         //     "NI" => "Nicaragua",
//         //     "NE" => "Niger",
//         //     "NG" => "Nigeria",
//         //     "NO" => "Norway",
//         //     "OM" => "Oman",
//         //     "PK" => "Pakistan",
//         //     "PW" => "Palau",
//         //     "PS" => "Palestine Autonomous",
//         //     "PA" => "Panama",
//         //     "PG" => "Papua New Guinea",
//         //     "PY" => "Paraguay",
//         //     "PE" => "Peru",
//         //     "PH" => "Philippines",
//         //     "PL" => "Poland",
//         //     "PT" => "Portugal",
//         //     "PR" => "Puerto Rico",
//         //     "QA" => "Qatar",
//         //     "RE" => "Reunion",
//         //     "RO" => "Romania",
//         //     "RU" => "Russian Federation",
//         //     "RW" => "Rwanda",
//         //     "VC" => "Saint Vincent and the Grenadines",
//         //     "MP" => "Saipan",
//         //     "SM" => "San Marino",
//         //     "SA" => "Saudi Arabia",
//         //     "SN" => "Senegal",
//         //     "SC" => "Seychelles",
//         //     "SL" => "Sierra Leone",
//         //     "SG" => "Singapore",
//         //     "SK" => "Slovak Republic",
//         //     "SI" => "Slovenia",
//         //     "SO" => "Somalia",
//         //     "ZA" => "South Africa",
//         //     "ES" => "Spain",
//         //     "LK" => "Sri Lanka",
//         //     "KN" => "St. Kitts/Nevis",
//         //     "LC" => "St. Lucia",
//         //     "SD" => "Sudan",
//         //     "SR" => "Suriname",
//         //     "SZ" => "Swaziland",
//         //     "SE" => "Sweden",
//         //     "CH" => "Switzerland",
//         //     "SY" => "Syria",
//         //     "TW" => "Taiwan",
//         //     "TI" => "Tajikistan",
//         //     "TZ" => "Tanzania",
//         //     "TH" => "Thailand",
//         //     "TG" => "Togo",
//         //     "TK" => "Tokelau",
//         //     "TO" => "Tonga",
//         //     "TT" => "Trinidad and Tobago",
//         //     "TN" => "Tunisia",
//         //     "TR" => "Turkey",
//         //     "TM" => "Turkmenistan",
//         //     "TC" => "Turks and Caicos Islands",
//         //     "TV" => "Tuvalu",
//         //     "UG" => "Uganda",
//         //     "UA" => "Ukraine",
//         //     "AE" => "United Arab Emirates",
//         //     "UY" => "Uruguay",
//         //     "UZ" => "Uzbekistan",
//         //     "VU" => "Vanuatu",
//         //     "VE" => "Venezuela",
//         //     "VN" => "Viet Nam",
//         //     "VG" => "Virgin Islands (British)",
//         //     "VI" => "Virgin Islands (U.S.)",
//         //     "WF" => "Wallis and Futuna Islands",
//         //     "YE" => "Yemen",
//         //     "YU" => "Yugoslavia",
//         //     "ZM" => "Zambia",
//         //     "ZW" => "Zimbabwe"
//         // );
//         return $country;
//     }
// }

if (!function_exists('getDisposition')) {
    function getDisposition($disposition_id)
    {
        $dailyCompaign = Disposition::where('id', $disposition_id)->first();
        return $dailyCompaign;
    }
}

if (!function_exists('getTeamMemberType')) {
    function getTeamMemberType($teamId, $userType)
    {
        $teamMembers = TeamMembers::where('team_id', $teamId)->where('user_type', $userType)->pluck('member_id');
        return $teamMembers->toArray();
    }
}

if (!function_exists('getTeamMembersNotifications')) {
    function getTeamMembersNotifications($user_id)
    {
        $teamMember = TeamMembers::where('member_id', $user_id)->first();
        if ($teamMember->user_type == config('main.roles_id.support.id')) {
            $teamMembers = TeamMembers::where('team_id', $teamMember->team_id)->whereIn('user_type', [3, 4, 5, 6, 7, 8])->pluck('member_id');
        }
        if ($teamMember->user_type == config('main.roles_id.support_lead.id')) {
            $teamMembers = TeamMembers::where('team_id', $teamMember->team_id)->whereIn('user_type', [3, 4, 5, 6, 7])->pluck('member_id');
        }
        if ($teamMember->user_type == config('main.roles_id.front.id')) {
            $teamMembers = TeamMembers::where('team_id', $teamMember->team_id)->whereIn('user_type', [3, 4, 5, 6, 7, 10])->pluck('member_id');
        }
        if ($teamMember->user_type == config('main.roles_id.front_lead.id')) {
            $teamMembers = TeamMembers::where('team_id', $teamMember->team_id)->whereIn('user_type', [3, 4, 5, 6, 7])->pluck('member_id');
        }
        if ($teamMember->user_type == config('main.roles_id.unit_head.id')) {
            $teamMembers = TeamMembers::where('team_id', $teamMember->team_id)->whereIn('user_type', [3, 4, 5, 6])->pluck('member_id');
        }
        if ($teamMember->user_type == config('main.roles_id.avp.id')) {
            $teamMembers = TeamMembers::where('team_id', $teamMember->team_id)->whereIn('user_type', [3, 4, 5])->pluck('member_id');
        }
        return $teamMembers->toArray();
    }
}

if (!function_exists('getTeamMembersPermission')) {
    function getTeamMembersPermission($user_id)
    {
        $teamMember = TeamMembers::where('member_id', $user_id)->first();
        if ($teamMember->user_type == config('main.roles_id.support.id')) {
            $teamMembers = TeamMembers::where('team_id', $teamMember->team_id)->whereIn('user_type', [3, 4, 5, 6, 7, 8])->pluck('member_id');
        }
        if ($teamMember->user_type == config('main.roles_id.support_lead.id')) {
            $teamMembers = TeamMembers::where('team_id', $teamMember->team_id)->whereIn('user_type', [3, 4, 5, 6, 7])->pluck('member_id');
        }
        if ($teamMember->user_type == config('main.roles_id.front.id')) {
            $teamMembers = TeamMembers::where('team_id', $teamMember->team_id)->whereIn('user_type', [3, 4, 5, 6, 7, 10])->pluck('member_id');
        }
        if ($teamMember->user_type == config('main.roles_id.front_lead.id')) {
            $teamMembers = TeamMembers::where('team_id', $teamMember->team_id)->whereIn('user_type', [3, 4, 5, 6, 7])->pluck('member_id');
        }
        if ($teamMember->user_type == config('main.roles_id.unit_head.id')) {
            $teamMembers = TeamMembers::where('team_id', $teamMember->team_id)->whereIn('user_type', [3, 4, 5, 6])->pluck('member_id');
        }
        if ($teamMember->user_type == config('main.roles_id.avp.id')) {
            $teamMembers = TeamMembers::where('team_id', $teamMember->team_id)->whereIn('user_type', [3, 4, 5])->pluck('member_id');
        }
        return $teamMembers->toArray();
    }
}

if (!function_exists('getCustomerName')) {
    function getCustomerName($customer_id)
    {
        $customer = Customer::where('id', $customer_id)->first();

        if ($customer->company != null) {
            return $customer->company;
        } else {
            return $CustomerContact = CustomerContact::select(
                DB::raw("CONCAT(first_name,' ',last_name) AS name"), 'customer_id')
                ->where('status', 1)->where('is_primary', 1)
                ->where('customer_id', $customer_id)
                ->pluck('name')->first();
        }
    }
}

if (!function_exists('getTaskMembers')) {
    function getTaskMembers($task_id)
    {
        return TaskUser::where('task_id', $task_id)->pluck('member_id')->toArray();
    }
}

if (!function_exists('getCategoryName')) {
    function getCategoryName($value)
    {
        return Categories::where('id', $value)->pluck('display_name')->first();
    }
}

function getUserImageNew($user)
{
//    $user = getUserDetail($id);
    if (isset($user->id)) {
        if (Cache::has('user-is-online-' . $user->id)) {
            echo '<div class="status dot dot-lg dot-success"></div>';
        } else {
            echo '<div class="status dot dot-lg dot-gray"></div>';
        }
    }

    if (isset($user->picture)) {
        return '<img src="' . asset('pictures/' . $user->picture) . '">';
    } else {
        if (isset($user->name)) {
            $nameParts = explode(' ', trim($user->name));
            $firstName = array_shift($nameParts);
            $lastName = array_pop($nameParts);
            $initials = mb_substr($firstName, 0, 1) . mb_substr($lastName, 0, 1);
            return strtoupper($initials);
        }
    }



}

if (!function_exists('getFilesGalary')) {
    function getFilesGalary($attachment_id, $remove_link = null)
    {
        $file_ids = explode(',', $attachment_id);
        $attachments = Attachment::whereIn('id', $file_ids)->get();
        $html = '<div class="nk-block"><div class="row g-gs">';
        foreach ($attachments as $attachment) {
            $exploded = explode('.', $attachment->name);
            $file_name = substr($attachment->name, 0, strrpos($attachment->name, "."));
            $file_ext = strtolower(end($exploded));
            if ($attachment->name) {

                if ($remove_link) {
                    $html .= '<div class="col-sm-6 col-lg-4"><div class="gallery gallery-content card card-bordered" data-toggle="tooltip" data-placement="top" title="' . $file_name . '"><a class="download" target="_blank" href="' . asset('attachments/' . $attachment->name) . '"><img src="' . asset('attachments/' . $attachment->name) . '"></a></div><a id="remove_file" data-file_name="' . $attachment->name . '" href="javascript:undefined;" >Remove file</a></div>';
                } else {
                    $html .= '<div class="col-sm-6 col-lg-4"><div class="gallery gallery-content card card-bordered" data-toggle="tooltip" data-placement="top" title="' . $file_name . '"><a class="download" target="_blank" href="' . asset('attachments/' . $attachment->name) . '"><img src="' . asset('attachments/' . $attachment->name) . '"></a></div></div>';
                }
            }
        }
        $html .= '</div></div>';
        return $html;
    }
}

if (!function_exists('getPublishStatus')) {
    function getPublishStatus($created_at, $updated_at)
    {
        if ($created_at == $updated_at) {
            return "<div><span>Published</span></div><div><span>" . formatDate($created_at) . ' ' . formatTime($created_at) . "</span></div>";
        } else {
            return "<div><span>Last Modified</span></div><div><span>" . formatDate($updated_at) . ' ' . formatTime($updated_at) . "</span></div>";
        }
    }
}


if (!function_exists('getNameById')) {
    function getNameById($user_id)
    {
        $user = User::find($user_id);
        if($user){
            return $user->name;
        }
    }
}


if (!function_exists('getCreateDateStatus')) {
    function getCreateDateStatus($created_at, $updated_at)
    {

            return "<div><span>Place Date</span></div><div><span>" . formatDate($created_at) . ' ' . formatTime($created_at) . "</span></div>";
    }
}



if (!function_exists('getMenu')) {
    function getMenu($manuName, $class)
    {
        $mainMenu = Menu::Where('title', $manuName)->first();
        $menus = Menuitem::Where(['parent' => null, 'menu_id' => ($mainMenu) ? $mainMenu->id : ''])->with('childCategories')->get();
        $html = '<ul class="' . $class . '">';
        foreach ($menus as $menu) {
            if (filter_var($menu->target, FILTER_VALIDATE_URL)) {
                $target = $menu->target;
            } else {
                $target = url($menu->target);
            }
            if (count($menu->childCategories)) {
                $html .= '<li class="dropdown"><a class="dropdown-toggle" class="nav-link" href="' . $target . '">' . $menu->title . '</a>';
                $html .= subMenu($menu->childCategories);
                $html .= '</li>';
            } else {
                $html .= '<li ><a class="nav-link" href="' . $target . '">' . $menu->title . '</a></li>';
            }
        }
        $html .= '</ul>';
        return $html;

    }

    function subMenu($datas)
    {
        //  return $data;
        $html = '<ul class="dropdown-menu">';
        foreach ($datas as $data) {
            if (filter_var($data->target, FILTER_VALIDATE_URL)) {
                $target = $data->target;
            } else {
                $target = url($data->target);
            }
            if (count($data->categories)) {
                $html .= '<li class="dropdown" ><a class="nav-link" class="dropdown-toggle" href="' . $target . '">' . $data->title . '</a>';
                $html .= subMenu($data->categories);
                $html .= '</li>';
            } else {
                $html .= '<li><a class="nav-link" href="' . $target . '">' . $data->title . '</a></li>';
            }
        }
        $html .= '</ul>';
        return $html;
    }

    //  set theme url
    if (!function_exists('theme_url')) {
        function theme_url($theme_name)
        {
            return url('resources/views/themes') .'/'. $theme_name . '/';
        }
    }

    //  get all testimonials
    //  parameter $count and $sortBy is optional is use for limit and sorting
    if (!function_exists('getTestimponials')) {
        function getTestimponials($count = null, $sortBy = 'DESC', $id = null, $slug = null)
        {
            $query = Testimonial::limit($count)->where('status', 'publish');
            if ($id) {
                $query = $query->where('id', $id);
            }
            if ($slug) {
                $query = $query->where('slug', $slug);
            }
            return $data = $query->orderBy('id', $sortBy)->get();
        }
    }

    //  get all Team Members
    //  parameter $count and $sortBy is optional is use for limit and sorting
    if (!function_exists('getMembers')) {
        function getMembers($count = null, $sortBy = 'DESC')
        {
            return TeamPage::limit($count)->where('status', 'publish')->orderBy('id', $sortBy)->get();
        }
    }

    //  get all services
    //  parameter $count and $sortBy is optional is use for limit and sorting
    if (!function_exists('getServices')) {
        function getServices($count = null, $sortBy = 'ASC')
        {
            return Service::limit($count)->where('status', 'publish')->orderBy('id', $sortBy)->get();
        }
    }

    //  get all service category with relative services
    if (!function_exists('getServicesCategory')) {
        function getServicesCategory($count = null, $sortBy = 'ASC', $class = '')
        {
            return ServiceCategory::limit($count)->where('status', 1)->with('sevices')->orderBy('id', $sortBy)->get();
        }
    }

    //  get all Blogs
    //  parameter $count and $sortBy is optional is use for limit and sorting
    if (!function_exists('getBlogs')) {
        function getBlogs($count = null, $sortBy = 'DESC', $id = null, $slug = null)
        {
            $query = Post::limit($count)->where('status', 'publish');
            if ($id) {
                $query = $query->where('id', $id);
            }
            if ($slug) {
                $query = $query->where('slug', $slug);
            }
            $query->with('user','comment')->orderBy('id', $sortBy);
            return $data = $query->get();
        }
    }

    //  get all Blogs category with blogs details
    //  parameter $count and $sortBy is optional is use for limit and sorting
    if (!function_exists('getBlogsCategory')) {
        function getBlogsCategory($count = null, $sortBy = 'DESC', $class = '')
        {
            return PostCategories::limit($count)->where('status', 1)->with('user', 'postAll')->orderBy('id', $sortBy)->get();

        }
    }

    //  get all Portfolio
    //  parameter $count and $sortBy is optional is use for limit and sorting
    if (!function_exists('getPortfolio')) {
        function getPortfolio($count = null, $sortBy = 'DESC')
        {
            return Portfolio::limit($count)->where('status', 'publish')->with('category')->orderBy('id', $sortBy)->get();
        }
    }

    if (!function_exists('getPortfolioCategory')) {
        function getPortfolioCategory($count = null, $sortBy = 'DESC', $class = '')
        {
            return PortfolioCategory::limit($count)->where('status', 1)->with('portfolio')->orderBy('id', $sortBy)->get();
        }
    }

    //  get all Portfolio
    //  parameter $sortBy is optional is use for sorting
    if (!function_exists('getSettingData')) {
        function getSettingData($name = null, $sortBy = 'DESC')
        {
            return Setting::where('name', $name)->with('user')->orderBy('id', $sortBy)->get();
        }
    }

    //  get all Product
    //  parameter $sortBy is optional is use for sorting
    if (!function_exists('getProduct')) {
        function getProduct($sortBy = 'DESC')
        {
            return Product::where('status', 'publish')->with('user')->orderBy('id', $sortBy)->get();
        }
    }
    //  get single Product Detail from slug
    //  parameter $sortBy is optional is use for sorting
    if (!function_exists('getProductDetail')) {
        function getProductDetail($slug = '', $sortBy = 'DESC')
        {
            return Product::where(['status' => 'publish', 'slug' => $slug])->with('user')->orderBy('id', $sortBy)->get();
        }
    }

    //  get all Banner
    //  parameter $count and $sortBy is optional is use for limit and sorting
    if (!function_exists('getBanner')) {
        function getBanner($category = null, $name = null, $sortBy = 'DESC')
        {
            if ($name) {
                return Banner::where(['title' => $name, 'status' => 'publish'])->with('user')->orderBy('id', $sortBy)->get();
            }
            return Banner::join('banner_categories', 'banners.banner_category_id', '=', 'banner_categories.id')
                ->where(['banner_categories.name' => $category,
                    'banner_categories.status' => '1',
                    'banners.status' => 'publish'])
                ->get();
        }
    }




    //  parameter $count and $sortBy is optional is use for limit and sorting
    if (!function_exists('getImageLink')) {
        function getImageLink($id)
        {
            $attachments = Attachment::whereId($id)->first();

            if ($attachments) {
                return asset('attachments') . '//' . $attachments->name;
            } else {
                return 'https://via.placeholder.com/150';
            }
        }
    }

    //  parameter $count and $sortBy is optional is use for limit and sorting
    if (!function_exists('getMultiImageLink')) {
        function getMultiImageLink($attachment_id)
        {
            $file_ids = explode(',', $attachment_id);
            $attachments = Attachment::whereIn('id', $file_ids)->get();
            $imageLink = [];
            if ($attachments->count() > 1) {
                foreach ($attachments as $image) {
                    $imageLink[] = asset('attachments') . '//' . $image->name;
                }

            } else {

                $imageLink[] = 'https://via.placeholder.com/300/000000/FFFFFF/?text='.$attachments[0]->name;

            }
            return $imageLink;
        }
    }


    if (!function_exists('getLogo')) {
        function getLogo($name = 'cms_logo')
        {
            $results = Setting::join('attachments', 'settings.attachment_id', '=', 'attachments.id')
                ->where('settings.name', $name)
                ->get();
            if ($results->count() > 0) {
                return asset('attachments\\') . $results[0]->name;
            } else {
                return asset('assets\images\informiatech_logo.png');
            }
        }
    }

    //  get custom section with section name parameter
    if (!function_exists('getCustomSection')) {
        function getCustomSection($sectionName = null)
        {
            $data = CustomSection::where(['status' => 'publish', 'name' => $sectionName])->get();
            // return $data;
            $data = ($data->count() > 0) ? $data[0]->description : '<center class="text-danger font-weight-bold">(' . $sectionName . ') IS not Exist In DataBase</center>';
            return $data;
        }
    }

    //  Create slug
    if (!function_exists('createslug')) {
        function createslug($data)
        {
            if ($data == 'App\Testimonial') {
                return "testimonials";
            } elseif ($data == 'App\Service') {
                return "services";
            } elseif ($data == 'App\Page') {
                return "pages";
            } elseif ($data == 'App\Post') {
                return "posts";
            } else {
                return '';
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $text send for convert to slug
     *         $divider is a divider
     *
     */
    function getslug($text, $divider = '_')
    {
        // replace non letter or digits by divider
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);
        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);
        // trim
        $text = trim($text, $divider);
        // remove duplicate divider
        $text = preg_replace('~-+~', $divider, $text);
        // lowercase
        $text = strtolower($text);
        if (empty($text)) {
            return 'n-a';
        }
        return $text;
    }

    if (!function_exists('getActiveTheme')) {
        function getActiveTheme()
        {
            $themeName = Setting::where('name', 'Active Theme')->first();
            return $themeName->description;
        }
    }

    if (!function_exists('getpostCommentbySlug')) {
        function getpostCommentbypostId($id)
        {
            return BlogComments::where(['status' => 'publish', 'post_id' => $id])->with('user')->get();
        }
    }

    if (!function_exists('getpostSEOSlug')) {
        function getpostSEOSlug($slug)
        {
            return Post::select('mate_title', 'mate_description', 'mate_keywords')->where('slug', $slug)->where('status', 'publish')->get();
        }
    }
    if (!function_exists('getProductSEOSlug')) {
        function getProductSEOSlug($slug)
        {
            return Product::select('mate_title', 'mate_description', 'mate_keywords')->where('slug', $slug)->where('status', 'publish')->get();
        }
    }
    if (!function_exists('getPageSEObySlug')) {
        function getPageSEObySlug($slug)
        {
            return Page::select('mate_title', 'mate_description', 'mate_keywords')->where('slug', $slug)->where('status', 'publish')->get();
        }
    }

    if (!function_exists('getPagebySlug')) {
        function getPagebySlug($slug)
        {
            return Page::with(['user'])->where('slug', $slug)->where('status', 'publish')->first();
        }
    }

    if (!function_exists('getServiceSEObySlug')) {
        function getServiceSEObySlug($slug)
        {
            return Service::select('mate_title', 'mate_description', 'mate_keywords')->where(['slug' => $slug, 'status' => 'publish'])->get();
        }
    }

    if (!function_exists('getServicebySlug')) {
        function getServicebySlug($slug)
        {
            return Service::where(['slug' => $slug, 'status' => 'publish'])->first();
        }
    }
    if (!function_exists('getTestimonialSEObySlug')) {
        function getTestimonialSEObySlug($slug)
        {
            return Testimonial::select('mate_title', 'mate_description', 'mate_keywords')->where(['slug' => $slug, 'status' => 'publish'])->get();
        }
    }


    if (!function_exists('getVariant')) {
        function getVariant($id)
        {
            return ProductVariant::join('product_sizes', 'product_variants.product_size_id', '=', 'product_sizes.id')
                ->where(['product_variants.product_id' => $id,
                    'product_variants.status' => 'publish'])
                ->select('product_sizes.id', 'product_sizes.name')
                ->distinct()
                ->get();

        }
    }
    if (!function_exists('getVariantColor')) {
        function getVariantColor($size, $color = null)
        {
            $query = ProductVariant::with('color', 'size');
            $query->where(['product_size_id' => $size, 'product_variants.status' => 'publish']);
            if ($color) {
                $query->where('product_color_id', $color);
            }
            return $query->get();

        }
    }

    if (!function_exists('getAllColor')) {
        function getAllColor()
        {
            return ProductColor::get();
        }
    }
    if (!function_exists('getAllSize')) {
        function getAllSize()
        {
            return ProductSize::get();
        }
    }

    if (!function_exists('addToCart')) {
        function addToCart($productId = null, $qty = null, $size = null, $color = null, $name = null, $price = null)
        {
            if ($productId) {
//                $data = [
//                    'product' => $productId,
//                    'qty' => $qty,
//                    'size' => $size,
//                    'color' => $color,
//                ];
//                Session::push('cart', $data);

                \Cart::add(array(
                    'id' => $productId, // inique row ID
                    'name' => $name,
                    'price' => $price,
                    'quantity' => $qty,
                    'attributes' => array(
                        'size' => $size,
                        'color' => $color
                    )
                ));

            }
            return \Cart::getTotalQuantity();

            /*if (session('cart')) {
                return count(session('cart'));
            }
            return '0';*/
        }
    }

    if (!function_exists('getCartProduct')) {
        function getCartProduct()
        {
            //  return Session::get('cart');

            $product = [];
            if (Session::get('cart')) {
                foreach (Session::get('cart') as $key => $value) {

                    if ($value['color'] || $value['size']) {
                        $query = ProductVariant::query();
                        if ($value['color']) {
                            $query = $query->where('product_color_id', $value['color']);
                        }
                        if ($value['size']) {
                            $query = $query->where('product_size_id', $value['size']);
                        }
                        $variant = $query->first();
                    } else {
                        $variant = null;
                    }
                    $data = [
                        'id' => $key,
                        'productDetail' => Product::whereId($value['product'])->first(),
                        'qty' => $value['qty'],
                        'variant' => $variant,
                        'color' => ProductColor::whereId($value['color'])->first(),
                        'size' => ProductSize::whereId($value['size'])->first(),
                    ];
                    $product[] = $data;
                }
            }

            return $product;
        }
    }

    function removeFromString($str, $item)
    {
        $parts = explode(',', $str);

        while (($i = array_search($item, $parts)) !== false) {
            unset($parts[$i]);
        }

        return implode(',', $parts);
    }

// =====================================================================
// =====================================================================
//           Beez Buncker theme functions
// =====================================================================
// =====================================================================


    if (!function_exists('getCountryList')) {
        function getCountryList($countryId = null)
        {
            return Country::where('status', '1')->with('state')->get();
        }
    }

    if (!function_exists('getCityList')) {
        function getCityList($stateId = null)
        {
            return City::where(['status' => '1','state_id' => $stateId])->get();
        }
    }

    if (!function_exists('getFeaturedCourse')) {
        function getFeaturedCourse()
        {
            //"Jun 23 2022"
            $currentDate = Date('M d y');
            $url = "https://www.golfnow.com/api/tee-times/tee-time-results";

                $curl = curl_init($url);
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                $headers = array(
                "Content-Type: application/json",
                );
                curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

                $data = '{
                "PageSize": 8,
                "PageNumber": 0,
                "Date": "'.$currentDate.'",
                "SortBy": "Facilities.Distance",
                "SortByRollup": "Facilities.Distance",
                "SortDirection": 0,
                "Latitude": 28.5383,
                "Longitude": -81.3792,
                "Radius": 25,
                "NextAvailableTeeTime": true,
                "Tags": "PMP",
                "View": "Featured-Near-Me-By-Popularity"
                }';

                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

                //for debug only!
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

                $resp = curl_exec($curl);
                curl_close($curl);
                $data =json_decode($resp, true);
                if(isset($data['message'])){
                    return $value = [];
                }
                return $data['ttResults']['facilities'];


        }
    }

    if (!function_exists('getHomeSliderCourse')) {
        function getHomeSliderCourse()
        {
            $currentDate = Date('M d y');
            $url = "https://www.golfnow.com/api/tee-times/tee-time-results";

            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $headers = array(
            "Content-Type: application/json",
            );
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            $data = <<<DATA
            {
            "PageSize": 8,
            "PageNumber": 0,
            "Date": "$currentDate",
            "SortBy": "Facilities.Distance",
            "SortByRollup": "Facilities.Distance",
            "SortDirection": 0,
            "Latitude": 28.5383,
            "Longitude": -81.3792,
            "Radius": 25,
            "NextAvailableTeeTime": true,
            "Holes": "Nine",
            "View": "Nine-Hole-Near-Me"
            }
            DATA;

            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

            //for debug only!
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            $resp = curl_exec($curl);
            curl_close($curl);
            // var_dump($resp);
            $data =json_decode($resp, true);
            if(isset($data['message'])){
                return $value = [];
            }
            return $data['ttResults']['facilities'];

        }
    }

    if (!function_exists('getRateStar')) {
        function getRateStar($rate)
        {
            $rateprsn = $rate / 5 * 100;
            return $data = <<<DATA
            <div class="star-rating" title="80%" style="font-size: 15px;">
            <div class="back-stars">
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <div class="front-stars" style="width: $rateprsn%">
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                </div>
            </div>
         </div>
         DATA;

        }
    }

    if (!function_exists('getGolfListCourses')) {
        function getGolfListCourses($log = null, $lat = null, $date = null,$hotDeal = false, $promoted = false,$distance = '50',$maxPrice = '10000',$minPrice = '0',$golfValue = '0',$holesValue = '3',$minTime = '10',$maxTime = '42')
        {

            if($date){
                $date = strtotime($date);
                $currentDate =date('M d y', $date);
            }else{
                $currentDate = Date('M d y');
            }

            $url = "https://www.golfnow.com/api/tee-times/tee-time-results";

            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $headers = array(
               "Content-Type: application/json",
            );
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            $data = '{"Radius":'.$distance.',"Latitude":'.$lat.',"Longitude":'.$log.',"PageSize":30,"PageNumber":0,"SearchType":"3","SortBy":"Facilities.Distance","SortDirection":"0","Date":"'.$currentDate.'","HotDealsOnly":"'.$hotDeal.'","PriceMin":'.$minPrice.',"PriceMax":'.$maxPrice.',"Players":'.$golfValue.',"Holes":'.$holesValue.',"RateType":"all","TimeMin":'.$minTime.',"TimeMax":'.$minTime.',"MarketId":4,"SortByRollup":"Facilities.Distance","View":"Course","ExcludeFeaturedFacilities":false,"TeeTimeCount":20,"PromotedCampaignsOnly":"'.$promoted.'","CurrentClientDate":"2022-06-27T19:00:00.000Z"}';
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

            //for debug only!
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            $resp = curl_exec($curl);
            curl_close($curl);
            $data =json_decode($resp, true);
            if(isset($data['ttException']['errorMessage'])){
                return $data['ttException'];
            }
            if(isset($data['message'])){
                return $value = [];
            }
            //  dd($data['ttResults']);
            return $data['ttResults'];

        }
    }

    if (!function_exists('getLocationFromLogLet')) {
        function getLocationFromLogLet($log , $lat)
        {
            $data = City::where(['status' => '1','log' => $log, 'lat'=> $lat])->with('state')->first();
            return ($data) ? $data['name'].', '.$data['state']['name'] : 'Orlando, FL';
        }
    }


    function getPurchaseItemQty($itemID)
    {
        $receivedItem = \App\Models\ReceiveItem::where('purchase_detail_id', $itemID)->get();
        return $receivedItem->sum('quantity');
    }

    function getPurchaseStatus($status)
    {
        if($status == "pending"){
            $html = '<span class="badges bg-lightred">Pending</span>';
        }
        elseif ($status == "partial_received"){
            $html = '<span class="badges bg-lightyellow">Partial Received</span>';
        }
        else {
            $html = '<span class="badges bg-lightgreen">Fully Received</span>';
        }

        return $html;
    }

    if (!function_exists('getProductIdBySku')) {
        function getProductIdBySku($sku)
        {
            $product = \App\Models\Inventory::where('sku', $sku)->first();
            if($product){
                return $product->product_id;
            }
        }
    }

    if (!function_exists('getBranch')) {
        function getBranch()
        {
            $bid = 2;
            $branch = \App\Models\Branch::find($bid);
            if($branch){
                return $branch;
            }
        }
    }

    function getProductQty($product_id)
    {
        $productQty = \App\Models\Inventory::where('product_id', $product_id)->get();
        return $productQty->sum('quantity');
    }

    function getDiscountByProductId($product_id)
    {
        $product = \App\Models\Products::where('id', $product_id)->first();
        if(isset($product)){
            return $product->discount.'%';
        } else {
            return '0%';
        }

    }

    function getProductName($product_id)
    {
        $product = \App\Models\Products::where('id', $product_id)->first();
        if(isset($product)){
            return $product->name;
        } else {
            return false;
        }

    }



    function getMedicineCostPrice($sku, $batchCode, $todaySale)
    {
        if($batchCode == NULL){
            $productId = 1213;

            $receivedItem = \App\Models\ReceiveItem::with(['purchaseDetailData','productUnitState' ])->where('sku', $sku)->latest()->first();
//            dump($receivedItem->toArray());
        }
        else {
            //dump('asd');
            $receivedItem = \App\Models\ReceiveItem::with(['purchaseDetailData', 'productUnitState'])->where('sku', $sku)->where('batch_code', $batchCode)->latest()->first();
        }

       // dd($receivedItem->purchaseDetailData);

        if(!isset($receivedItem->purchaseDetailData)){
            return 0;
        }

        $itemQuantity = $receivedItem->productUnitState->where('unit_id', $receivedItem->purchaseDetailData->unit_id)->first();
        $saleItemQuantity = $receivedItem->productUnitState->where('unit_id', $todaySale->unit_id)->first();

//        dump($batchCode, $receivedItem->purchaseDetailData->toArray(), $todaySale->toArray());

//        dump($itemQuantity->quantity);

        $itemQuantitydata = ($itemQuantity && $itemQuantity->quantity != NULL) ? $itemQuantity->quantity : 1;


        if($receivedItem->purchaseDetailData->unit_id == 1){
            $pricePerPeace = $receivedItem->purchaseDetailData->cost_price;
        }
        else {
            $pricePerPeace = $receivedItem->purchaseDetailData->cost_price / (double) $itemQuantitydata;
        }

//        dump($pricePerPeace);

//        // ALP 0.5MG
//        if($todaySale->product_id == 1751){
//            dd($batchCode, $receivedItem->toArray(), $todaySale->unit_id, $todaySale->toArray(), $itemQuantitydata, $saleItemQuantity->quantity);
//        }


        //dd($todaySale->quantity,$saleItemQuantity->quantity);

        if($todaySale->unit_id == 1){
            $actualPrice = $todaySale->quantity * $pricePerPeace;
        }
        else {

            //$actualPrice = ($todaySale->quantity *  isset($saleItemQuantity) ? $saleItemQuantity->quantity : 0) * $pricePerPeace;


            $qtty = (isset($saleItemQuantity->quantity)) ? $saleItemQuantity->quantity : 0;

            //$actualPrice = ($todaySale->quantity *  $saleItemQuantity->quantity) * $pricePerPeace;
            $actualPrice = ($todaySale->quantity *  $qtty) * $pricePerPeace;

        }
        return $actualPrice;
//        return 0;
    }
}

