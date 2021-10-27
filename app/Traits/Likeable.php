<?php
namespace App\Traits;

use App\Exceptions\LikeableException;
use App\Models\LikeRequest;
use Illuminate\Database\Eloquent\Model;
const PENDING = 0;
const ACCEPTED = 1;
const DENIED = 2;
const BLOCKED = 3;
trait Likeable {

    public function friends()
    {
        return $this->morphMany(LikeRequest::class, 'sender');
    }


    public function getFriendShipStatus(Model $recipient){
        if ($friendship = $this->getFriendship($recipient)) {
            if($friendship->status === ACCEPTED){
                return  'REQUEST_ACCEPTED';
            }elseif ($friendship->status === DENIED){
                return  'REQUEST_DENIED';
            }elseif ($friendship->status === PENDING){
                if($friendship->sender_id === $this->id){
                    return 'REQUEST_SENT';
                }
                return  'REQUEST_PENDING';
            }
        }
        return 'SEND_REQUEST';
    }


    public function getFriendship(Model $recipient)
    {
        return $this->findFriendship($recipient)->first();
    }


    public function sendRequest(Model $recipient){
        if (!$this->canBefriend($recipient)) {
            return false;
        }

        $friendship = (new LikeRequest)->fillRecipient($recipient)->fill([
            'status' => PENDING,
        ]);
        $this->friends()->save($friendship);
        return $friendship;
    }


    public function acceptRequest(Model $recipient)
    {
        if ($friendship = $this->getFriendship($recipient)) {
            if($friendship->status === ACCEPTED){
                throw new LikeableException('Request already accepted');
            }
        }
        $updated = $this->findFriendship($recipient)->whereRecipient($this)->update([
            'status' => ACCEPTED,
        ]);
        return $updated;
    }

    public function denyRequest(Model $recipient)
    {
        if ($friendship = $this->getFriendship($recipient)) {
            if($friendship->status === DENIED){
                throw new LikeableException('Request already rejected');
            }
        }
        $updated = $this->findFriendship($recipient)->whereRecipient($this)->update([
            'status' => DENIED,
        ]);
        return $updated;
    }

    public function cancelRequest(Model $recipient){
        if($this->hasSentRequestTo($recipient)){
            LikeRequest::where('sender_id',$this->id)
                ->where('recipient_id',$recipient->id)
                ->where('status',PENDING)
                ->delete();
            return true;
        }
        throw new LikeableException('You haven\'t any request in pending with specified user');
    }

    public function hasRequestFrom(Model $recipient)
    {

        return $this->findFriendship($recipient)->whereSender($recipient)->whereStatus(PENDING)->exists();
    }

    public function hasSentRequestTo(Model $recipient)
    {
        return LikeRequest::whereSender($this)->whereRecipient($recipient)->whereStatus(PENDING)->exists();
    }

    public function canBefriend($recipient)
    {

        if($recipient->id === $this->id){
            return  false;
        }
        if ($friendship = $this->getFriendship($recipient)) {
            if ($friendship->status === DENIED ) {
                throw new LikeableException('Your request has been denied already');
            }else if ($friendship->status === ACCEPTED ) {
                throw new LikeableException('You are already liked');
            }else if ($friendship->status === PENDING) {
                throw new LikeableException('You already have a request in pending');
            }
        }
        return true;
    }


    public function getLikeRequestsSent($offset=0,$limit=10)
    {
        $recipients =  LikeRequest::whereSender($this)->whereStatus(PENDING)->get(['recipient_id']);
        return $this->whereIn('id', $recipients)->skip($offset)->take($limit)->get();
    }

    public function getLikeRequestsReceived($offset=0,$limit=10)
    {
        $senders =  LikeRequest::whereRecipient($this)->whereStatus(PENDING)->get(['sender_id']);
        return $this->whereIn('id', $senders)->skip($offset)->take($limit)->get();
    }


    public function getFriends($offset=0,$limit=20)
    {
        return $this->getFriendsQueryBuilder()->skip($offset)->take($limit)->get();
    }

    public function getAllFriendships()
    {
        return $this->findFriendships(null)->get();
    }

    private function findFriendship(Model $recipient)
    {
        return LikeRequest::betweenModels($this, $recipient);
    }


    private function findFriendships($status = null)
    {

        $query = LikeRequest::where(function ($query) {
            $query->where(function ($q) {
                $q->whereSender($this);
            })->orWhere(function ($q) {
                $q->whereRecipient($this);
            });
        });

        //if $status is passed, add where clause
        if (!is_null($status)) {
            $query->where('status', $status);
        }

        return $query;
    }


    private function getFriendsQueryBuilder($status=ACCEPTED)
    {

        $friendships = $this->findFriendships($status)->get(['sender_id', 'recipient_id']);
        $recipients  = $friendships->pluck('recipient_id')->all();
        $senders     = $friendships->pluck('sender_id')->all();
        return $this->where('id', '!=', $this->getKey())->whereIn('id', array_merge($recipients, $senders));
    }




}
