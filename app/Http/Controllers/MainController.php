<?php

namespace App\Http\Controllers;

use App\Mail\EmailVerifyNotification;
use App\Models\Author;
use App\Models\Bookmark;
use App\Models\Like;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MainController extends Controller
{
    public function home()
    {
        $latestQuotes = Quote::latest()->take(8)->get();
        $popularQuotes = Quote::where('popular', true)->inRandomOrder()->take(8)->get();
        $popularAuthors = Author::where('popular', true)->inRandomOrder()->take(8)->get();

        return view('home.index', compact('latestQuotes', 'popularQuotes', 'popularAuthors'));
    }

    public function like(Request $request)
    {
        $liked = Like::where('user_id', Auth::user()->id)
                    ->where('quote_id', $request->quote_id)
                    ->where('author_id', $request->author_id)
                    ->first();

        if($liked) {
            $liked->delete();

            $status = 'unliked';
        } else {
            $like = new Like();
            $like->user_id = Auth::user()->id;
            $like->quote_id = $request->quote_id;
            $like->author_id = $request->author_id;
            $like->save();

            $status = 'liked';
        }

        $likesCount = Like::where('quote_id', $request->quote_id)
                    ->where('author_id', $request->author_id)
                    ->count();

        return [
            'status' => $status,
            'likesCount' => $likesCount
        ];
    }

    public function bookmark(Request $request)
    {
        $bookmarked = Bookmark::where('user_id', Auth::user()->id)
                    ->where('quote_id', $request->quote_id)
                    ->where('author_id', $request->author_id)
                    ->first();

        if($bookmarked) {
            $bookmarked->delete();

            $status = 'removed-from-bookmarks';
        } else {
            $bookmark = new Bookmark();
            $bookmark->user_id = Auth::user()->id;
            $bookmark->quote_id = $request->quote_id;
            $bookmark->author_id = $request->author_id;
            $bookmark->save();

            $status = 'added-into-bookmarks';
        }

        return [
            'status' => $status
        ];
    }
}
