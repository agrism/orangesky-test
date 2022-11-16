<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\InputRequest;
use App\Http\Resources\CalculatorResource;
use App\Logic\Contracts\DataSources\HistoryReadInterface;
use App\Logic\Contracts\DataSources\HistoryStoreInterface;
use App\Logic\Contracts\CalculatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Exception;

final class IndexController extends Controller
{
    public function __invoke(
        InputRequest $request,
        CalculatorInterface $calculator,
        HistoryStoreInterface $historyStore,
        HistoryReadInterface $historyRead
    ): Response {
        try {
            $operandOne = floatval($request->input('operandOne'));
            $operandTwo = floatval($request->input('operandTwo'));
            $operator = strval($request->input('operator'));

            $calculator
                ->setOperand($operandOne)
                ->setOperand($operandTwo)
                ->setOperator($operator)
                ->calculate();

            $result = ROUND($calculator->result(), 5);

            $historyStore->store(sprintf('%s%s%s=%s', $operandOne, $operator, $operandTwo, $result));

            return response()->json(new CalculatorResource([
                'result' => $result,
                'history' => $historyRead->read(5)
            ]), Response::HTTP_OK);

        } catch (Exception) {
            return response()->noContent(Response::HTTP_BAD_REQUEST);
        }
    }
}
