<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Message extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * HasMany relationships with MessageDetail
     * @return HasMany
     */
    public function details(): HasMany
    {
        return $this->hasMany(MessageDetail::class);
    }

    /**
     * HasMany relationships with UserMessage
     * @return HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(UserMessage::class);
    }

    /**
     * BelongsTo relationships with User
     * @return BelongsTo
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * BelongsTo relationships with Designation
     * @return BelongsTo
     */
    public function designation(): BelongsTo
    {
        return $this->belongsTo(Designation::class);
    }

    /**
     * assign users to message
     * @param mixed $users
     * 
     * @return void
     */
    public function assignUsers($users)
    {
        foreach($users as $value){
            $um = new UserMessage();
            $um->message_id = $this->id;
            $um->receiver_id = $value;
            $um->save();
        }

        $um = new UserMessage();
        $um->message_id = $this->id;
        $um->receiver_id = 1;
        $um->save();
    }

    /**
     * @param Builder $query
     * @param Builder $search
     *
     * @return Builder
     */
    public function scopeWithQuery(Builder $query)
    {
        $user = Auth::user();
        return $query->with('sender:id,name,email', 'users.user', 'details', 'details.sender')
                    ->addSelect(['designation' => Designation::select('name')
                        ->whereColumn('id', 'messages.designation_id')
                        ->latest()->take(1)
                    ])->where('sender_id', $user->id);
    }
    
    /**
     * @param Builder $query
     * @param Builder $search
     *
     * @return Builder
     */
    public function scopeSearch(Builder $query, $search)
    {
        if($search != ''){
            return $query->where('subject', 'LIKE', '%'.$search.'%')
                    ->orWhere('message', 'LIKE', '%'.$search.'%')
                    ->orWhereHas('designation', function($q) use($search){
                        $q->where('name', 'LIKE', '%'.$search.'%');
                    })
                    ->orWhereHas('users.user', function($q) use($search){
                        $q->where('name', 'LIKE', '%'.$search.'%');
                    });
        }
    }
}
