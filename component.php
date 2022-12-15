<?php
function component($courseimg,$coursename,$courseDesc,$courseprice,$courseid){
    $element="
    <div class=\"column\">
    <form action=\"course.php\" method=\"post\">
        <div class=\"course-img\">
            <img src=\"$courseimg\" alt=\"Image1\">
        </div>
        <div class=\"course-body\" >
            <div class=\"column2\">
                <h3 class\"course-name\">$coursename</h3>
            </div>
            <div class=\"column3\">
                <p class=\"course-text\">$courseDesc</p>
            </div>
            <div class=\"column2\">
                <h4 class=\"course-price\">$$courseprice <br ><del class=\"course-old-price\">RM3999.00</del></h4>
            </div>
            <div class=\"column2\">
            <button type=\"submit\" name=\"add\" class=\"add\">Add to Cart <i class=\"fas fa-shopping-cart\"></i> </button>
            </div>
            <input type='hidden' name='course-id' value='$courseid'>
        </div>
        </form>
    </div>    
    
    ";

    echo $element;
}

function element($courseimg,$coursename,$courseprice,$courseid){
    $element="
    <form action=\"cart.php?action=remove&id=$courseid\" method=\"post\" class=cart-items>
    <div class=\"course-body\">
        <div class=\"item\">
            <img src=\"$courseimg\" alt=\"logo\">
        </div>
        <div class=\"item\">
            <h4 class=\"course-name\"> $coursename</h4>                           
            <h4 class=\"course-price\"> $$courseprice</h4>               
        </div>
        <div class=\"item\">
            <button type=\"submit\" name=\"remove\" > <i class=\"fas fa-trash-alt\"></i> Remove </button>
        </div>
    </div>
    </form>
    ";

    echo $element;
}

function invoice($coursename,$courseprice){
    
    $element="
    <div class=\"invoice-container\">
        <form action=\"success.php\" method=\"post\">
            <table class=\"invoice-table\">
            <tr class=\"invoice-row\">
                <td class=\"invoice-name\">$coursename</td>
                <td class=\"invoice-price\">$$courseprice</td>
            </tr>
            </table>
        </form>
    </div>";
    

    echo $element;
}    
?>