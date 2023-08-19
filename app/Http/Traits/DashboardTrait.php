<?php
namespace App\Http\Traits;
use App\Models\Department;
use App\Models\Course;
use App\Models\TeachingLoad;

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
    public static function categorize_load_dept($collection)
    {
        $departments = Department::all();

        $departmentData = array();

        foreach ($departments as $department) {
            $departmentData[$department['department']] = array(
                "department_name" => $department,
                "min_load" => 0,
                "extra_load" => 0,
                "under_load" => 0,
                "department_id" => $department['id']
            );
        }

        foreach ($collection as $staffMember) {
            $department = $staffMember['deparment'];
            $sum = $staffMember['sum'];

            if ($sum <= 8) {
                $departmentData[$department]['under_load']++;
            } elseif ($sum <= 12) {
                $departmentData[$department]['min_load']++;
            } else {
                $departmentData[$department]['extra_load']++;
            }
        }

        // $departmentStats = array_values($departmentData);



        $arrayOfObjects = [];

        // $arrayData = json_decode($departmentData, true);

        foreach ($departmentData as $key => $value) {
            $object = (object) $value;
            $object->department_name = $key;
            $arrayOfObjects[] = $object;
        }



        return $arrayOfObjects;
    }
    /*Calculate allocated and unallocated courses */
    public static function allocate_unallocate_func()
    {
        $all_courses = Course::all();
        $teaching_load = TeachingLoad::all();
        $allocated = 0;
        //    $magic = array();
        $magic = collect([]);

        $magic = $magic->unique();

        foreach($teaching_load as $value)
        {
            foreach(json_decode($value->courses) as $m)
            {
                foreach($all_courses as $course)
                {
                    if($m == $course->course_name)
                    {
                        if (!$magic->contains($m)) {
                            $magic->add($m);
                        }
                    }
                }
            }
        }

        return ["allocated_courses" => $magic->count(), "all_courses"=>$all_courses->count()];
    }
}

