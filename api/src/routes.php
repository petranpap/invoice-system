<?php

// header('Access-Control-Allow-Origin: https://www.facebook.com');
//     header("Access-Control-Allow-Credentials: true");
//     header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
//     header('Access-Control-Max-Age: 1000');
//     header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');

// // Login
//     $app->get('/login/{username}/{password}', function ($request, $response, $args) {
//          $sth = $this->db->prepare("SELECT * FROM parent inner join childs on childs.parent_id=parent.parent_id WHERE parent.parent_user_name=:username and pass =:password ");
//         $sth->bindParam(":username", $args['username']);
//         $sth->bindParam(":password", $args['password']);
//         $sth->execute();
//         $todos = $sth->fetchAll();
//         return $this->response->withJson($todos);
//     });

// Retrieve all 
    $app->get('/all', function ($request, $response, $args) {
         $sth = $this->db->prepare("SELECT * FROM receipts order by invoice ASC ");
        $sth->execute();
        $todos = $sth->fetchAll();
        return $this->response->withJson($todos);
    });
 
    // Retrieve invoice with invoice_id 
    $app->get('/invoice/[{id}]', function ($request, $response, $args) {
         $sth = $this->db->prepare("SELECT * FROM receipts WHERE invoice=:id");
        $sth->bindParam("id", $args['id']);
        $sth->execute();
        $todos = $sth->fetchObject();
        return $this->response->withJson($todos);
    });
    
      // Add a new todo
    $app->post('/newreceipts', function ($request, $response) {
        $input = $request->getParsedBody();
        $sql = "INSERT INTO receipts (`address`, `year`, `name`, `model`, `vin`, `invoice`, `table_json`) VALUES (:address,:year,:name,:model,:vin,:invoice,:table_json)";
         $sth = $this->db->prepare($sql);
        $sth->bindParam("address", $input['address']);
        $sth->bindParam("year", $input['year']);
        $sth->bindParam("name", $input['name']);
        $sth->bindParam("model", $input['model']);
        $sth->bindParam("vin", $input['vin']);
        $sth->bindParam("invoice", $input['invoice']);
        $sth->bindParam("table_json", $input['table_json']);
        $sth->execute();
        return  'ack_insert';
    });

    
    // Update todo with given id
    $app->put('/update/[{invoice}]', function ($request, $response, $args) {
        $input = $request->getParsedBody();
        $sql = "UPDATE receipts SET address=:address, year=:year,name=:name,model=:model,vin=:vin,table_json=:table_json WHERE invoice=:invoice";
         $sth = $this->db->prepare($sql);
        $sth->bindParam("invoice", $args['invoice']);
        $sth->bindParam("address", $input['address']);
        $sth->bindParam("year", $input['year']);
        $sth->bindParam("name", $input['name']);
        $sth->bindParam("model", $input['model']);
        $sth->bindParam("vin", $input['vin']);
        $sth->bindParam("table_json", $input['table_json']);
        $sth->execute();
        $input['invoice'] = $args['invoice'];
        return  'ack_update';
    });

    
    

    // // Update from Browser add-on ( Child Aprroves Parental Options)
    // $app->put('/update/browser_addon/parental/options/{fb_url}', function ($request, $response, $args) {
    //     $input = $request->getParsedBody();
    //     $sql = "UPDATE parental_visibility inner join childs on childs.child_id=parental_visibility.child_id
    //         SET parental_visibility.child_aproved=1 where childs.child_fb_url=:fb_url";
    //     $sth = $this->db->prepare($sql);
    //     $sth->bindParam(":fb_url", $args['fb_url']);
    //     $sth->execute();
    //     $input['fb_url'] = $args['fb_url'];
    //     return $this->response->withJson($input);
    // });




