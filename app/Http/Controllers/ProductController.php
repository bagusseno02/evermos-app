<?php
/**
 * @author <a href="mailto:bagus.seno39@gmail.com>seno</a>
 * Created on 25/02/21
 * Project evermos-service
 */

namespace App\Http\Controllers;

use App\Traits\ProductTrait;
use App\Transformers\EmploymentTypeChildTransformer;
use App\Transformers\ProductTransformer;
use App\Utilities\Constants\HttpStatusCodes;
use App\Utilities\Exception\DatabaseException;
use App\Utilities\Exception\ValidationParameterException;
use App\Utilities\Responses\ApiBaseResponseBuilder;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Jojonomic\JojoUtilities\Responses\JojoApiBaseResponseBuilder;

/**
 * Class ProductController
 * @package App\Http\Controllers
 */
class ProductController extends Controller
{
    use ProductTrait;

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationParameterException
     * @throws DatabaseException
     */
    public function create(Request $request): JsonResponse
    {
        $response = new ApiBaseResponseBuilder();

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
            'stock' => 'required'
        ]);

        if ($validator->fails()) {
            throw new ValidationParameterException(implode($validator->errors()->all(), " | "), "createProduct.validator");
        }

        DB::beginTransaction();

        try {

            $product = $this->createProduct($request->all());
            if (empty($product)) {
                $response->withDefaultMessage('createProduct.create', 'Failed create product, problem insert to database', false,
                    HttpStatusCodes::HTTP_BAD_REQUEST);
                return $response->showResponse();
            }

        } catch (Exception $ex) {
            DB::rollback();
            throw new DatabaseException($ex->getMessage(), "createProduct.insertProduct.database");
        }

        DB::commit();

        $response->withData($product);
        $response->withMessage('Successfully create product');
        $response->withDataTransformers(new ProductTransformer());
        return $response->showResponse();
    }

    /**
     * @param $id
     * @return JsonResponse
     * @throws DatabaseException
     */
    public function delete($id): JsonResponse
    {
        $response = new ApiBaseResponseBuilder();

        DB::beginTransaction();

        try {
            $product = $this->findByIdProduct($id);

            if (!$product) {
                return response()->json([
                    'error' => 'Data does not exist',
                ], HttpStatusCodes::HTTP_BAD_REQUEST);
            }

            $this->deleteProduct($product);
        } catch (Exception $ex) {
            DB::rollback();
            throw new DatabaseException($ex->getMessage(), "deleteProduct.deleteProduct.database");
        }

        DB::commit();

        $response->withMessage('Product has been deleted');
        return $response->showResponse();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function list(Request $request): JsonResponse
    {
        $response = new ApiBaseResponseBuilder();
        $results = $this->listProduct($request);
        $product = $results['data'];

        $response->withLength($results['length']);
        $response->withData($product);
        $response->withMessage('Successfully get list product');
        $response->withDataTransformers(new ProductTransformer());
        return $response->showResponse();
    }

    /**
     * @param $id
     * @return JsonResponse
     * @throws DatabaseException
     */
    public function detail($id): JsonResponse
    {
        $response = new ApiBaseResponseBuilder();
        DB::beginTransaction();

        try {
            $product = $this->findByIdProduct($id);

            if (!$product) {
                return response()->json([
                    'error' => 'Data does not exist',
                ], HttpStatusCodes::HTTP_BAD_REQUEST);
            }
        } catch (Exception $ex) {
            DB::rollback();
            throw new DatabaseException($ex->getMessage(), "detailProduct.detailProduct.database");
        }

        DB::commit();

        $response->withData($product);
        $response->withMessage('Successfully get product detail');
        return $response->showResponse();
    }

    /**
     * @param $id
     * @param Request $request
     * @return JsonResponse
     * @throws DatabaseException
     * @throws ValidationParameterException
     */
    public function update($id, Request $request): JsonResponse
    {
        $response = new ApiBaseResponseBuilder();

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
            'stock' => 'required'
        ]);

        if ($validator->fails()) {
            throw new ValidationParameterException(implode($validator->errors()->all(), " | "), "createProduct.validator");
        }

        DB::beginTransaction();

        try {
            $product = $this->findByIdProduct($id);
            $product = $this->updateProduct($product, $request->all());
            if (empty($product)) {
                $response->withDefaultMessage('createProduct.create', 'Failed create product, problem insert to database', false,
                    HttpStatusCodes::HTTP_BAD_REQUEST);
                return $response->showResponse();
            }

        } catch (Exception $ex) {
            DB::rollback();
            throw new DatabaseException($ex->getMessage(), "createProduct.insertProduct.database");
        }

        DB::commit();

        $response->withData($product);
        $response->withMessage('Successfully update product');
        $response->withDataTransformers(new ProductTransformer());
        return $response->showResponse();

    }

}