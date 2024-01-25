<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Page;

class PageController extends Controller
{
    public function New() {
        return view('admin.page.new');
    }

    public function NoArabic($input) {
        $output = str_replace('ي', 'ی', $input);
        $output = str_replace('ك', 'ک', $output);
        return $output;
    }

    public function NoRelatives($input) {
        $relative = 'src="../../';
        $absolute = 'src="'.ENV('APP_URL')."/";
        $output = str_replace($relative, $absolute , $input);
        return $output;
    }

    public function Submit(Request $request) {
        $request->validate([
            'title' => 'required|min:1|max:400',
            'content' => 'required|min:1'
        ]);

        $page = new Page();

        $page->title =  $this->NoArabic($request['title']);
        $page->content =  $this->NoArabic($request['content']);
        $page->content =  $this->noRelatives($request['content']);

        $page->meta_description = isset($request['meta-description']) ?  $this->NoArabic($request['meta-description']) : '';
        $page->meta_robots = isset($request['meta-robots']) ? $request['meta-robots'] : 'index, follow';

        $page->user_id = Auth::id();

        if ($request['publish']) {
            $page->state = 1;
            $page->previous_state = 1;
        }
        if ($request['draft']) {
            $page->state = 0;
            $page->previous_state = 0;
        }
        $page->save();
        return redirect(route('Admin > Page > Edit', $page->id));
    }

    public function Manage(Request $request)
    {
      // to fetch deleted items
      if ($request->has('state') && $request['state'] == '-1') {
          $pages = Page::where('state', '-1')->latest()->paginate(15);
      }
      // to fetch drafted items
      elseif ($request->has('state') && $request['state'] == '0') {
          $pages = Page::where('state', '0')->latest()->paginate(15);
      }
      // to fetch all items [except deleted]
      else {
          $pages = Page::where('state', '!=', -1)->latest()->paginate(15);
      }
        return view('admin.page.manage', compact('pages'));
    }

    public function Show($slug) {
        $page = Page::where('slug', '=', $slug)->get();
        if (!count($page) || ($page[0]->state !== 1)) {
            return abort('404');
        }
        return view('public.page.single', compact('page'));
    }

    public function Edit($id) {
        $page = Page::find($id);
        return view('admin.page.edit', compact('page'));
    }

    public function Update(Request $request, $id) {
        $request->validate([
            'title' => 'required|min:1|max:400',
            'content' => 'required|min:1|'
        ]);

        $page = Page::find($id);

        $page->title =  $this->NoArabic($request['title']);
        $page->content =  $this->NoArabic($request['content']);
        $page->content =  $this->NoRelatives($request['content']);

        $page->meta_description = isset($request['meta-description']) ?  $this->NoRelatives($request['meta-description']) : '';
        $page->meta_robots = isset($request['meta-robots']) ? $request['meta-robots'] : 'index, follow';

        if ($request['draft']) {
            $page->state = $page->previous_state;
            $page->state = 0;
        }
        if ($request['publish']) {
            $page->state = $page->previous_state;
            $page->state = 1;
        }
        $page->save();
        return redirect(route('Admin > Page > Edit', $id));
    }

    public function DeleteTemporary($id)
    {
        $page = Page::find($id);
        $page->previous_state = $page->state;
        $page->state=-1;
        $page->save();
        return back();
    }

    public function DeletePermanently($id)
    {
        $page = Page::where('id',$id)->delete($id);
        return back();
    }

    public function Delete($id) {
        $page = Page::find($id)->delete();
        return back();
    }

    public function Restore($id)
    {
        $page = Page::find($id);
        $page->state = $page->previous_state;
        $page->save();
        return back();
    }
}
