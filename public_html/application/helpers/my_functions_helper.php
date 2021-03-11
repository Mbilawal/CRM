<?php 
add_action('after_render_single_aside_menu','my_custom_menu_items');

function my_custom_menu_items($order){
    if($order == 1){
        echo '<li>';
        echo '<a href="#" aria-expanded="false"><i class="fa fa-balance-scale menu-icon"></i>
            Merchants Management<span class="fa arrow"></span>
            </a>';

        echo '<ul class="nav nav-second-level collapse" aria-expanded="false">
               <li><a href="https://crm.dryvarfoods.com/admin/clients">Testing</a></li>
             </ul>';
        echo '</li>';
    }
}