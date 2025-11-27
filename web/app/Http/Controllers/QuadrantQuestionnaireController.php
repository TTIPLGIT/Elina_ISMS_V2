<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class QuadrantQuestionnaireController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $method = 'Method => QuadrantQuestionnaireController => index';
        $gatewayURL = config('setting.api_gateway_url') . '/quadrant/questionnaire/index';
        $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
        $response = json_decode($response);

        $objData = json_decode($this->decryptData($response->Data));

        $rows = json_decode(json_encode($objData->Data), true);
        // dd($rows);
        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];

        return view('QuadrantQuestionnaire.index', compact('screens', 'modules', 'rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $method = 'Method => QuadrantQuestionnaireController => create';
        try {            
            $gatewayURL = config('setting.api_gateway_url') . '/quadrant/questionnaire/create';
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));

                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows =  $parant_data['rows'];

                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    return view('ovm1.create', compact('rows', 'screens', 'modules', 'rows'));
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == "401") {
                    return redirect(route('/'))->with('danger', 'User session Exipired');
                }
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // dd($this->decryptData($id));
        try {
            $method = 'Method => QuadrantQuestionnaireController => show';
            $gatewayURL = config('setting.api_gateway_url') . '/questionnaire/sensoryreport/' . $id; //Initially the report is only available for sensory questionnaire later it was extanded 
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response); //dd($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $questions = $parant_data['questions'];
                    // 
                    $uniqueQuadrants = array_unique(array_column($questions, 'quadrant'));
                    $uniqueQuadrants = array_map(function ($value) {return $value !== null ? $value : 'No Quadrant';}, $uniqueQuadrants);
                    $customOrder = array("AVOIDING", "SEEKING", "SENSITIVITY", "REGISTRATION", "No Quadrant");
                    uasort($uniqueQuadrants, function ($key1, $key2) use ($customOrder) {return array_search($key1, $customOrder) - array_search($key2, $customOrder);});
                    $uniqueQuadrantTypes = array_filter(array_unique(array_column($questions, 'quadrant_type')));
                    
                    $groupedData = [];
                    foreach ($questions as $item) {
                        $quadrant = $item['quadrant'] ?: 'No Quadrant';
                        $quadrantType = $item['quadrant_type'] ?? '';
                        if ($quadrantType !== '') {
                            $groupedData[$quadrantType][$quadrant][] = $item['value'];
                        }
                    }
                    // 
                    // dd($groupedData);
                    // dd($uniqueQuadrants);
                    $childName = $parant_data['child_name'];
                    $head = "Sensory processing refers to the brain’s ability to organize, interpret, and respond to information received from each of the senses. 
                    When interruption or disruption occurs in the processing of information from one or more of these areas, the ability to self-regulate and organize oneself may become compromised. {$childName} demonstrates some signs and symptoms of sensory processing difficulty at this time.
                    The sensory information is separated into 4 quadrants to determine how your child is reacting to various sensory inputs.
                    Please, refer to the quadrant below for details.";
                    $footer = "The Sensory Profile analysis reveals that {$childName} can successfully use and understand some sensory information, and has major difficulty understanding and using other sensory information. He exhibits a low threshold for  sensory processing difficulties frequently feel overwhelmed, uncomfortable, confused, and unsure of their own bodies. As a result, he may respond inappropriately to the demands of life, having difficulty negotiating with others, attending to important information, and managing their emotions.
                    {$childName} will benefit from intensive Occupational therapy to regulate his sensory processing channels more efficiently.";
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    return view('questionnaire_for_parents.sensory_report', compact('groupedData', 'uniqueQuadrants', 'uniqueQuadrantTypes', 'head', 'footer', 'childName', 'questions', 'screens', 'modules'));
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }
    public function executive_report($id)
    {
        // dd($this->decryptData($id));
        try {
            $method = 'Method => QuadrantQuestionnaireController => show';
            $gatewayURL = config('setting.api_gateway_url') . '/questionnaire/executive_report/' . $id;
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response); //dd($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $questions = $parant_data['questions'];
                    // dd($questions);
                    $childName = $parant_data['child_name'];
                    $head = "Executive functions are the cognitive abilities needed to control our thoughts, emotions and actions. His manifesting
                    difficulty as reported by his parents and teachers are his challenges in the areas of EF. In order to differential diagnosis, an
                    assessment was administered to rule out any deficits in the skill area of executive function (EF). The questionnaire was
                    designed to provide a better understanding of the child’s self-control and problem-solving skills by measuring eight aspects
                    of executive functioning.";
                    $footer = "The Sensory Profile analysis reveals that {$childName} can successfully use and understand some sensory information, and has major difficulty understanding and using other sensory information. He exhibits a low threshold for  sensory processing difficulties frequently feel overwhelmed, uncomfortable, confused, and unsure of their own bodies. As a result, he may respond inappropriately to the demands of life, having difficulty negotiating with others, attending to important information, and managing their emotions.
                    {$childName} will benefit from intensive Occupational therapy to regulate his sensory processing channels more efficiently.";
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    return view('questionnaire_for_parents.executive_report', compact('head', 'footer', 'childName', 'questions', 'screens', 'modules'));
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }

    public function executive_report_update(Request $request)
    {
        // dd($request);
    }
    public function sensory_report_update(Request $request)
    {
        // dd($request);
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
