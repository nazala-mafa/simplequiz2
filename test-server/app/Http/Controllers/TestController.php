<?php

namespace App\Http\Controllers;

use App\Models\AnswerModel;
use App\Models\QuestionModel;
use App\Models\TestModel;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\HeaderBag;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TestModel::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        TestModel::create([
            'test' => $request->test,
            'desc' => $request->desc,
            'user_id' => 1
        ]);
        return response([ 'message' => 'Test Baru Telah Ditambahkan' ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $test = TestModel::where('id', $id)->first();
        return response([
            'data' => [
                'test' => $test->toArray(),
                'questions' => $test->questions()->select(['id', 'id as qId', 'quest'])->get()->each(function($quest) {
                    $answers = $quest->answers()->select(['id as aId', 'text'])->get()->toArray();
                    shuffle($answers);
                    $quest->answers = $answers;
                    return $quest;
                })
            ]
        ]);
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
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        TestModel::where('id', $id)->delete();
        return response([ 'message' => 'Test Berhasil Dihapus' ])->setStatusCode(200);
    }

    public function getScore($testId, $userId) {
        
        $answersId = array_map(function($row) {
            return $row['answerId'];
        }, request()->all());
        
        $trueAnswersCount = AnswerModel::where('is_true', 1)->whereIn('id', $answersId)->count();
        $questionsCount = QuestionModel::where('test_id', $testId)->count();

        return response([
            'score' => $trueAnswersCount/$questionsCount,
            'isPassed' => ($trueAnswersCount/$questionsCount >= .7)
        ]);
    }
}
