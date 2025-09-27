<?php
namespace Database\Seeders;

use App\Models\ProductFulfillmentStepDependency;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\FulfillmentStep;
use App\Models\ProductFulfillmentStep;

class FulfillmentSeeder extends Seeder
{
    public function run(): void
    {
        // master steps
        $survey = FulfillmentStep::firstOrCreate(['key' => 'survey'], [
            'name' => 'Site Survey',
            'description' => 'A Survey is required on the installation site.',
        ]);

        $apiOrder = FulfillmentStep::firstOrCreate(['key' => 'api_order'], [
            'name' => 'API Order',
            'description' => 'An order must be placed via the provider api.',
        ]);

        $assignIp = FulfillmentStep::firstOrCreate(['key' => 'assign_ip'], [
            'name' => 'Assign IP',
            'description' => 'An IP address must be assigned to the router.',
        ]);

        $configureRouter = FulfillmentStep::firstOrCreate(['key' => 'configure_router'], [
            'name' => 'Configure Router',
            'description' => 'The router must be configured with the correct settings.',
        ]);

        $ship = FulfillmentStep::firstOrCreate(['key' => 'ship'], [
            'name' => 'Ship Product',
            'description' => 'The product must be shipped to the installation site.',
        ]);

        $sim = FulfillmentStep::firstOrCreate(['key' => 'sim_card'], [
            'name' => 'Sim Card',
            'description' => 'A standard or E Sim card must be assigned to the customer.',
        ]);

        $mobileNumber = FulfillmentStep::firstOrCreate(['key' => 'mobile_number_assignment'], [
            'name' => 'Mobile Number Assignment',
            'description' => 'A mobile number must be assigned to the sim card.',
        ]);

        $data = FulfillmentStep::firstOrCreate(['key' => 'mobile_data_plan'], [
            'name' => 'Mobile Data Plan',
            'description' => 'A Data plan must be applied to the sim.',
        ]);

        // products
        $broadband = Product::firstOrCreate(['name' => 'Owen Group Fibre to the Cabinet (FTTC) 1GB / 100MB']);
        $router = Product::firstOrCreate(['name' => 'Downs-Kane Fibre Router Model-867ZF']);
        $mobileData = Product::firstOrCreate(['name' => 'Guerra, Yang and Edwards Unlimited Data Plan Model-047nn']);

        // broadband steps
        $bbSurveyStep = ProductFulfillmentStep::firstOrCreate([
            'product_id' => $broadband->id,
            'fulfillment_step_id' => $survey->id,
            'step_order' => 1,
        ]);

        $bbApiStep = ProductFulfillmentStep::firstOrCreate([
            'product_id' => $broadband->id,
            'fulfillment_step_id' => $apiOrder->id,
            'step_order' => 2,
        ]);

        // router steps
        $routerAssignIpStep = ProductFulfillmentStep::firstOrCreate([
            'product_id' => $router->id,
            'fulfillment_step_id' => $assignIp->id,
            'step_order' => 1,
        ]);

        $configureRouterStep = ProductFulfillmentStep::firstOrCreate([
            'product_id' => $router->id,
            'fulfillment_step_id' => $configureRouter->id,
            'step_order' => 2,
        ]);

        $shipRouterStep = ProductFulfillmentStep::firstOrCreate([
            'product_id' => $router->id,
            'fulfillment_step_id' => $ship->id,
            'step_order' => 3,
        ]);

        // mobile data plan steps
        ProductFulfillmentStep::firstOrCreate([
            'product_id' => $mobileData->id,
            'fulfillment_step_id' => $sim->id,
            'step_order' => 1,
        ]);

        ProductFulfillmentStep::firstOrCreate([
            'product_id' => $mobileData->id,
            'fulfillment_step_id' => $mobileNumber->id,
            'step_order' => 2,
        ]);

        ProductFulfillmentStep::firstOrCreate([
            'product_id' => $mobileData->id,
            'fulfillment_step_id' => $data->id,
            'step_order' => 3,
        ]);

        // dependencies
        ProductFulfillmentStepDependency::firstOrCreate([
            'product_fulfillment_step_id' => $bbApiStep->id,
            'depends_on_step_id' => $bbSurveyStep->id,
        ]);

        ProductFulfillmentStepDependency::firstOrCreate([
            'product_fulfillment_step_id' => $configureRouterStep->id,
            'depends_on_step_id' => $routerAssignIpStep->id,
        ]);

        ProductFulfillmentStepDependency::firstOrCreate([
            'product_fulfillment_step_id' => $shipRouterStep->id,
            'depends_on_step_id' => $configureRouterStep->id,
        ]);
    }
}
