<html>
    <head>
    <meta charset="utf-8">    
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= 'Products List'; ?></title>
    <style type="text/css">
        .reports_table {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
        }
        .reports_table td, .reports_table th {
        border: 1px solid #ddd;
        padding: 8px;
        }
        .reports_table tr:nth-child(even){background-color: #f2f2f2;}
        .reports_table tr:hover {background-color: #ddd;}

        .reports_table th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #04AA6D;
        color: white;
        }
    </style>
    </head>

    <body>
        <div class="responsive">
        <table id="customers" class="table table-bordered table-striped reports_table" style="width: 100%;" >
                <thead>
                    <tr class="bold text-center">
                        <th style="width: 40%"> English Name </th>
                        <th style="width: 40%"> Name </th>
                        <th style="width: 20%"> Price </th>
                    </tr>
                </thead>
                <tbody>
                    <?php   
                    foreach ($products as $value) {
                    ?>   
                    <tr>
                        <td width="40%"> <?= $value->second_name ?> </td>
                        <td width="40%"> <?= $value->name ?> </td>
                        <td width="20%"> <?= number_format($value->price, 2)  ?> </td>
                    </tr>
                    <?php  
                    } 
                    ?>
            </tbody>
        </table>
        </div>
    </body>
</html>
