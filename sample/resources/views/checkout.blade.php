@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
     
        <div class="col-md-10">
            <div class="panel panel-default">
                <div class="panel-heading"><h3>Checkout<h3></div>

                <div class="panel-body">  
                         <table id="table" class="table table-striped">                      
                                  <thead>
                                      <tr>
                                          <th>Product name</th>
                                          <th>Quantity</th>
                                          <th>Base Amount</th>
                                      </tr>
                                  </thead>
                                @foreach($checkouts as $checkout)
                                  <tbody>
                                      <tr>
                                            <td> <p>{{ $checkout->product_name }}</p> </td> 
                                            <td> <p>{{ $checkout->quantity }}</p> </td>
                                            <td> <p>{{ $checkout->base }}</p></td>
                                            <td> <p>{{ $checkout->amount }}</p></td>
                                      </tr>
                                  </tbody>           
                                @endforeach
                            </table>
        
                               <p>Total Amount : </p> {{ $checkout->total_amount }}
                                <p>Total Items : </p>{{ $checkout->total_item }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
