<div class="row">

    <div class="col-12">
        <div class="card">
        <div class="row">
            <div class="card-body table-responsive">

                <table class="table table-bordered nowrap"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>Sr. No.</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <!-- <th>Employee ID</th> -->
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Wallet</th>
                            <th>Password</th>
                            <th>Added Date and Time</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach($AllAgent as $agent) { ?> 
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= $agent->first_name ?></td>
                                <td><?= $agent->last_name ?></td>
                                <!-- <td><?= $agent->id ?></td> -->
                                <td><?= $agent->email_id ?></td>
                                <td><?= $agent->mobile ?></td>
                                <td><?= $agent->wallet ?></td>
                                <td><?= $agent->password ?></td>
                                <td><?= $agent->created_date ?></td>
                                <td>

                                    
                                |<a href="<?= base_url('backend/Agent/users/' . $agent->id) ?>" class="btn btn-info"
                                 data-toggle="tooltip" data-placement="top" title="View Wins"><span
                                class="fa fa-eye"></span></a> 

                                |<a href="<?= base_url('backend/Agent/view/' . $agent->id) ?>" class="btn btn-info"
                                 data-toggle="tooltip" data-placement="top" title="View Wins"><span
                                class="fa fa-eye"></span></a> 

                                |<a href="<?= base_url('backend/Agent/edit_wallet/' . $agent->id) ?>"class="btn btn-info"
                                data-toggle="tooltip" data-placement="top" title="Add Wallet"><span class="fa fa-credit-card" ></span></a>

                                |<a href="<?= base_url('backend/Agent/deduct_wallet/' . $agent->id) ?>"class="btn btn-danger"
                                data-toggle="tooltip" data-placement="top" title="Deduct Wallet"><span class="fa fa-credit-card" ></span></a>
                                
                                <a href="<?= base_url('backend/Agent/edit_Agent/' . $agent->id) ?>" class="btn btn-info"
                                data-toggle="tooltip" data-placement="top" title="Edit"><span class="fa fa-edit"></span></a>

                                |<a href="<?= base_url('backend/Agent/delete/' . $agent->id) ?>" class="btn btn-danger"
                                 data-toggle="tooltip" data-placement="top" title="Delete" onclick="return confirm('Are You Sure Want To Delete <?= $agent->first_name ?>?')"><span class="fa fa-trash"></span></a>

                        </td>                            

                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        </div>
    </div>
</div>
