<?php

namespace App\Models;
use App\Traits\Admin\FilterTrait;
use App\Traits\DataTrait;
use App\Traits\PGSMetable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Spatie\Permission\Traits\HasRoles;
use Storage;

class User extends Authenticatable implements AuditableContract {
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;

    use DataTrait, FilterTrait;
    use Notifiable, SoftDeletes;
    use HasRoles, HasApiTokens;
    use \OwenIt\Auditing\Auditable;
    use Sluggable;

    use PGSMetable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'name_arabic',
        'user_slug',
        'first_name',
        'middle_name',
        'last_name',
        'designation',
        'photo',
        'user_approved',
        'username',
        'email',
        'email_verified_at',
        'is_email_verified',
        'password',
        'api_token',
        'remember_token',
        'status',
        'is_super_admin',
        'force_password_change',
        'password_changed',
        'last_logged_in',
        'user_validate_code',
        'phone_number',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public function sluggable(): array{
        return [
            'user_slug' => [
                'source' => 'name',
            ],
        ];
    }

    protected $with = ['meta'];

    protected $auditExclude = [
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    private static $filters = [
        'filter_name' => ['q' => 'like', 'type' => 'text', 'title' => 'name'],
        'filter_email' => ['q' => '=', 'type' => 'text', 'title' => 'email', 'model' => ''],
        'filter_status' => ['q' => '=', 'type' => 'select', 'model' => '', 'title' => 'status', 'data' => ['1' => 'Active', '2' => 'Inactive']],
        'filter_user_approved' => ['q' => '=', 'type' => 'select', 'model' => '', 'title' => 'status', 'data' => ['1' => 'Approved', '2' => 'Rejected', '3' => 'Pending']],

    ];

    public function isUser() {
        return $this->is_admin === 2;
    }

    public function isBackendUser() {
        return $this->is_backend_user == 1;
    }

    public function isFrontendUser() {
        return $this->is_backend_user == 2;
    }

    public function isAdmin() {
        return $this->is_admin === 1;
    }

    public function isSuperAdmin() {
        return $this->is_super_admin === 1;
    }

    public static function admin_exist() {
        $tmp = User::where('is_admin', '=', 1)->first();
        return empty($tmp);
    }
    public function scopeActive($query) {
        return $query->where('status', '=', 1);
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->getData('name');
    }
    public function getUsername() {
        return $this->username;
    }
    function getEmail() {
        return $this->email;
    }
    public function getTitle() {
        return $this->name;
    }

    public function getSlug() {
        return $this->user_slug;
    }

    public function getEmailAddress() {
        return $this->email;
    }

    public function getPhoneNumber() {
        return $this->phone_number;
    }

    public function getStatus() {
        return $this->status;
    }

    public function userEmirate() {
        return $this->hasOne('App\Models\EmiratesModel', 'uae_id', 'user_emirate');
    }

    public function getRoles($html = false) {
        $arr = [];
        if (!empty($this->roles) && $this->roles->count() > 0) {
            foreach ($this->getRoleNames() as $role) {
                if ($html) {
                    $arr[] = '<span class="border-gray badge badge-light">' . $role . '</span>';
                } else {
                    $arr[] = $role;
                }
            }
        }
        return $html ? implode(' ', $arr) : implode(', ', $arr);
    }
    public function getImage($type = "") {
        $imageURL = "";

        switch ($type) {
            default:
                $type = $this->user_avatar;
                break;
        }

        $locationOrig = '/userAvatars/';
        $locationResized = '/userAvatars/large/';

        if (empty($this->user_avatar)) {
            $imageURL = asset('assets/admin/img/admin-avatar.png');
        } else {
            if (Storage::disk('local')->has('/public' . $locationResized . $type) && \File::exists(storage_path('app/public' . $locationResized . $type))) {
                $imageURL = asset('storage' . $locationResized . $type);
            } else if (Storage::disk('local')->has('/public' . $locationOrig . $type) && \File::exists(storage_path('app/public' . $locationOrig . $type))) {
                $imageURL = asset('storage' . $locationOrig . $type);
            }
        }

        return $imageURL;
    }
    public function getCreatedAt() {
        return date('d M Y H:i:s A', strtotime($this->created_at));
    }
}
