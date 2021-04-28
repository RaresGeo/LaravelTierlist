<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Template;
use App\Models\Tierlist;
use Illuminate\Http\Request;

class TierlistController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index(Template $template)
    {
        $tierlist = Tierlist::where('template_id', $template->id)->where('user_id', auth()->user()->id)->firstOr(function () use ($template) {

            // Assign the two foreign keys
            $newTierlist = Tierlist::make([]);
            $newTierlist->user_id = auth()->user()->id;
            $newTierlist->template_id = $template->id;
            $newTierlist->save();


            // Give it all images from the template as items
            foreach ($template->images as $image) {
                $newItem = Item::make([]);
                $newItem->image_id = $image->id;
                $newItem->tierlist_id = $newTierlist->id;
                /*$newItem = $newTierlist->items()->create([
                    'image_id' => $image->id
                ]);*/
                $newItem->save();
            }

            $newTierlist->save();
            return $newTierlist;
            dd($newTierlist);
        });

        return view('users.tierlists.newtierlist', [
            'tierlist' => $tierlist
        ]);
    }

    public function update(Request $request)
    {
        // Get item
        $item = Item::where('id', $request->only('item-id'));

        // Assign values to item
        $item->update([
            'name' => $request->name,
            'score' => $request->score,
            'variables' => $request->variables,
        ]);
    }
}
