<?php

namespace App\Http\Controllers;

use App\Models\AnswerModel;
use App\Models\QuestionModel;
use App\Models\TestModel;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $test = TestModel::where('id', request()->get('id'))->first();
        return response([
            'data' => [
                'test' => $test->toArray(),
                'questions' => $test->questions()->select(['id', 'id as qId', 'quest'])->get()->each(function($quest){
                    $quest->answers = array_map(function($answer){
                        return [
                            'text' => $answer['text'],
                            'is_true' => $answer['is_true'] == '1'
                        ];
                    }, $quest->answers()->select(['text', 'is_true'])->get()->toArray());
                })
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $questionId = $request->question_id;
        if($questionId) {
            QuestionModel::where('id', $questionId)->update([
                'test_id' => $request->test_id,
                'quest' => $request->quest
            ]);
        }else{
            $questionId = QuestionModel::insertGetId([
                'test_id' => $request->test_id,
                'quest' => $request->quest
            ]);
        }

        AnswerModel::where('question_id', $questionId)->delete();
        $answersData = array_map(function($row)use($questionId){
            $row['question_id'] = $questionId;
            return $row;
        }, $request->answers);
        AnswerModel::insert($answersData);

        return response(['message' => 'Pertanyaan Berhasil Ditambah.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
