<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
   protected $fillable = ['body','user_id'];
   public function question(){
       return $this->belongsTo(Question::class);
   }
   public function user(){
       return $this->belongsTo(User::class);
   }
   
   public static function boot() {
       parent::boot();
       static::created(function($answer){
           $answer->question->increment('answers_count');
          
       });
       static::deleted(function($answer){
           $question = $answer->question;
           $question->decrement('answers_count');
           if($question->best_answers_id === $answer->id){
               $question->best_answers_id = NULL;
               $question->save();
           }
           
       });
   }
   
   public function getStatusAttribute(){
       return $this->id === $this->question->best_answers_id ? 'vote-accepted':'';
   }

   public function getIsBestAttribute(){
      return $this->id === $this->question->best_answers_id;
   }

   public function getBodyHtmlAttribute(){
        return \Parsedown::instance()->text($this->body);
    }
    
    public function getCreateDateAttribute(){
        return $this->created_at->diffForHumans();
    }

    public function votes(){
        return $this->morphToMany(User::class, 'votable')
                ->withTimestamps();
    }
    
    public function upvotes(){
        return $this->votes()->wherePivot('vote', 1 );
    }    

    public function downVotes(){
        return $this->votes()->wherePivot('vote', -1 );
    }
}
