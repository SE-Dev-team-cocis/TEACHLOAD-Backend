<?php
namespace App\Http\Traits;

trait DashboardTrait {
    public function sample_index() {
        return 1;
    }
    /* Calculate totat CUs for specific staff */
    public static function calculate_cus($collection, $staff)
    {
        $sum = 0;
        $summary_load = array();
       foreach($collection as $value)
       {
          $obj = null;
          $staff_name = $department = null;

          foreach(json_decode($value['CUs']) as $m)
          {
            $sum += $m;
          }

          foreach($staff as $member)
          {
            if($member['id'] == $value['staff_id'])
            {
                $staff_name = $member['firstName']. " " .$member['lastName'] ;
                $department = $member['department'];
            }
          }

          $obj["staff"] = $staff_name;
          $obj['sum'] = $sum;
          $obj['deparment'] = $department;

          $sum = 0;
          array_push($summary_load, $obj);
       }
       return $summary_load;
    }

      /*Categorize load */
      public static function categorize_load($collection)
      {
          $under_load = $min_load = $extra_load = 0;
          foreach($collection as $value)
          {
              if($value['sum'] <=8 ){
                  $under_load++;
              }elseif ($value['sum'] <= 12){
                   $min_load++;
              }else{
                   $extra_load++;
              }
          }

          return ["under_load" => $under_load, "min_load" => $min_load, "extra_load" => $extra_load];
      }
     /*Categorize load  according to department*/

}
