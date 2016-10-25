<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'bzk_user_info';
    public $timestamps = false;

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $fillable = ['mobile', 'password', 'createTime'];
    protected $hidden = ['password'];


    public function createUser($data)
    {
        $userInfo = $this->create($data);
        return $userInfo->attributes['id'];
    }

    public function delUser($data)
    {
        $re_status = $this->where($data)->delete();
        return $re_status;
    }

    public function showUser($data = '', $offset = '', $number = '')
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

    public function updateUser($data)
    {
        $re_status = $this->where('id', $data['id'])->update($data);
        return $re_status;
    }
}
