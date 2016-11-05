<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;

class Device extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'bzk_device_info_log';
    public $timestamps = false;

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $guarded = [];


    public function createDevice($data)
    {
        $deviceInfo = $this->create($data);
        return $deviceInfo->toArray();
    }

    public function delDevice($data)
    {
        $re_status = $this->where($data)->delete();
        return $re_status;
    }

    public function showDevice($data = '', $offset = '', $number = '')
    {
        if ('' != $data){
            if ('' != $offset && '' != $number) {
                $result = $this->where($data)->skip($offset)->take($number)->get();
            } else {
                $result = $this->where($data)->get();
            }
        } else {
            if ('' != $offset && '' != $number) {
                $result = $this->skip($offset)->take($number)->get();
            } else {
                $result = $this->get();
            }
        }
        return $result;
    }

    public function updateDevice($data)
    {
        $re_status = $this->where('id', $data['id'])->update($data);
        return $re_status;
    }
}
