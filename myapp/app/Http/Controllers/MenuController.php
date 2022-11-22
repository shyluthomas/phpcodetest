<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getmenu() {
        
        try {
            return response()->json($this->getAllMenu());
        } catch (\Exception $e) {
            $content = array(
                'success' => false,
                'data' => 'something went wrong.',
                'message' => 'There was an error while processing your request: ' .
                $e->getMessage()
            );
            return response()->json($content)->setStatusCode(500);
        }  
    }
    
    /**
     * Display a listing of the resource.
     *
     * @param  $response Array
     * @param  $parentID int or NULL
     * 
     * @return $response Array
     */
    private function getAllMenu($response = [], $parentID = NULL){
        
        //get Menus from parent ID (Model: Menu)
        $parentMenus = Menu::getmenusByParent($parentID);
        
        foreach($parentMenus as $key => $parentMenu){
            $response[$key]['id'] = $parentMenu->id;
            $response[$key]['name'] = $parentMenu->name;
            $response[$key]['type'] = $parentMenu->type;
            $response[$key]['children'] = $this->getAllMenu([], $parentMenu->id);
        }
        
        return $response;
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu) {
        //
    }
}
