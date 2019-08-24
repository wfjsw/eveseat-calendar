<?php

Route::group([
    'namespace' => 'Seat\Kassie\Calendar\Http\Controllers',
    'middleware' => ['web', 'auth'],
    'prefix' => 'character',
], function() {

    Route::get('/view/paps/{character_id}', [
        'as' => 'character.view.paps',
        'uses' => 'CharacterController@paps',
        'middleware' => 'characterbouncer:kassie_calendar_paps',
    ]);

});

Route::group([
    'namespace' => 'Seat\Kassie\Calendar\Http\Controllers',
    'middleware' => ['web', 'auth'],
    'prefix' => 'corporation',
], function() {

    Route::get('/view/paps/{corporation_id}', [
        'as' => 'corporation.view.paps',
        'uses' => 'CorporationController@getPaps',
        'middleware' => 'corporationbouncer:kassie_calendar_paps',
    ]);

    // Route::get('/view/paps/{corporation_id}/json/year', [
    //     'as' => 'corporation.ajax.paps.year',
    //     'uses' => 'CorporationController@getYearPapsStats',
    //     'middleware' => 'corporationbouncer:kassie_calendar_paps',
    // ]);

    // Route::get('/view/paps/{corporation_id}/json/stacked', [
    //     'as' => 'corporation.ajax.paps.stacked',
    //     'uses' => 'CorporationController@getMonthlyStackedPapsStats',
    //     'middleware' => 'corporationbouncer:kassie_calendar_paps',
    // ]);

});

Route::group([
    'namespace' => 'Seat\Kassie\Calendar\Http\Controllers',
    'middleware' => ['web', 'auth', 'bouncer:calendar.view'],
    'prefix' => 'calendar'
], function () {

    Route::group([
        'prefix' => 'ajax'
    ], function(){

        Route::get('/operation/{id}', [
            'as' => 'operation.detail',
            'uses' => 'AjaxController@getDetail'
        ])->where('id', '[0-9]+');

        Route::get('/operation/allops', [
            'as' => 'operation.allops',
            'uses' => 'AjaxController@getAllOps',
        ]);

        // Route::get('/operation/ongoing', [
        //     'as' => 'operation.ongoing',
        //     'uses' => 'AjaxController@getOngoing',
        // ]);

        // Route::get('/operation/incoming', [
        //     'as' => 'operation.incoming',
        //     'uses' => 'AjaxController@getIncoming',
        // ]);

        // Route::get('/operation/faded', [
        //     'as' => 'operation.faded',
        //     'uses' => 'AjaxController@getFaded',
        // ]);
    });

    Route::group([
        'prefix' => 'operation'
    ], function() {

        Route::get('/', [
            'as' => 'operation.index',
            'uses' => 'OperationController@index'
        ]);

        Route::post('/', [
            'as' => 'operation.store',
            'uses' => 'OperationController@store',
            'middleware' => 'bouncer:calendar.create'
        ]);

        Route::post('update', [
            'as' => 'operation.update',
            'uses' => 'OperationController@update',
        ]);

        Route::post('subscribe', [
            'as' => 'operation.subscribe',
            'uses' => 'OperationController@subscribe'
        ]);

        Route::post('cancel', [
            'as' => 'operation.cancel',
            'uses' => 'OperationController@cancel',
        ]);

        Route::post('activate', [
            'as' => 'operation.activate',
            'uses' => 'OperationController@activate',
        ]);

        Route::post('close', [
            'as' => 'operation.close',
            'uses' => 'OperationController@close'
        ]);

        Route::post('delete', [
            'as' => 'operation.delete',
            'uses' => 'OperationController@delete',
        ]);

        Route::get('{id}', 'OperationController@index');

        Route::get('find/{id}', 'OperationController@find');

        Route::get('/{id}/paps', [
            'as'   => 'operation.paps',
            'uses' => 'OperationController@paps',
        ]);

        Route::post('/{id}/manualpaps', [
            'as'   => 'operation.manualpaps',
            'uses' => 'OperationController@manualPaps',
        ]);

    });

    Route::group([
        'prefix' => 'setting',
        'middleware' => 'bouncer:calendar.setup'
    ], function() {

        Route::get('/', [
            'as' => 'setting.index',
            'uses' => 'SettingController@index'
        ]);


        Route::group([
            'prefix' => 'slack'
        ], function() {

            Route::post('update', [
                'as' => 'setting.slack.update',
                'uses' => 'SettingController@updateSlack'
            ]);

        });

        Route::group([
            'prefix' => 'tag'
        ], function() {

            Route::post('create', [
            'as' => 'setting.tag.create',
            'uses' => 'TagController@store'
            ]);

            Route::post('delete', [
                'as' => 'setting.tag.delete',
                'uses' => 'TagController@delete'
            ]);

            Route::get('show/{id}', [
                'as' => 'tags.show',
                'uses' => 'TagController@get',
                'middleware' => 'bouncer:calendar.setup',
            ]);

            Route::post('update', [
                'as' => 'setting.tag.update',
                'uses' => 'TagController@store'
            ]);

        });

    });

    Route::group([
        'prefix' => 'lookup'
    ], function() {

        Route::get('fc', 'LookupController@lookupFC');
        Route::get('characters', 'LookupController@lookupCharacters');
        Route::get('systems', 'LookupController@lookupSystems');
        Route::get('attendees', 'LookupController@lookupAttendees');
        Route::get('confirmed', 'LookupController@lookupConfirmed');

    });


});
