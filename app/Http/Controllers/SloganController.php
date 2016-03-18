<?php

use App\Slogan;
use Illuminate\Http\Request;


class SloganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $approved = App\Slogan::where("approved","=",1)->get();
        //$unapproved = Slogan::where("approved","=",0)->get();

        return View::make('slogans', array(
          "approved"=>$approved->toJson(),
          //"unapproved"=>$unapproved,
          "games_list"=>$this->getCachedGameList(),
          "random_text"=>$this->getRandomText()
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        $this->validate($request, [
           'slogan'=>'required|unique:slogans|min:3|string|max:50'
        ]);
        Slogan::create([
            'slogan'=>$request->input('slogan'),
            'approved'=>0
        ]);

        return Redirect::to("/slogans")->with('status','Slogan submitted. If its any good we might approve it. Thanks!');
    }

    public function admin(){

        $approved = Slogan::where("approved",1)->orderBy("updated_at","desc")->get();
        $unapproved = Slogan::where("approved",0)->orderBy("updated_at","desc")->get();

        return View::make('slogans.admin', array(
            "approved"=>$approved,
            "unapproved"=>$unapproved,
            "games_list"=>$this->getCachedGameList(),
            "random_text"=>$this->getRandomText()
        ));
    }

    public function approve($id){
        Slogan::find($id)->approve();
    }

    public function reject($id){
        Slogan::find($id)->reject();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        Slogan::destroy($id);
    }
}
