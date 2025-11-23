<script setup>
import { Link } from '@inertiajs/vue3';
import AddStudent from '../AddForm/AddStudent.vue';
</script>
<template>
  <div class="bg-white w-[175px] px-5 print:hidden">
    <span class="uppercase block py-3">Inventory Management</span>
    <hr class="mb-5" />
    
    <!-- <Link class="text-[14px] hover:text-main/80 flex items-center gap-3 mb-5" :class="$page?.props?.menu == 'Store' ? 'text-main/80' : ''" :href="route('store.index')">
      Store
    </Link> -->
     <Link class="text-[14px] hover:text-main/80 flex items-center gap-3 mb-5" :class="$page?.props?.menu == 'Sell' ? 'text-main/80' : ''" :href="route('sell.index')">
      Sells
    </Link>
     <Link class="text-[14px] hover:text-main/80 flex items-center gap-3 mb-5" :class="$page?.props?.menu == 'Purchase' ? 'text-main/80' : ''" :href="route('productPurchase.index')">
      Purchase
    </Link>
    <Link class="text-[14px] hover:text-main/80 flex items-center gap-3 mb-5" :class="$page?.props?.menu == 'Stock' ? 'text-main/80' : ''" :href="route('stock.manager')">
      Stock Management
    </Link>
   
    <Link class="text-[14px] hover:text-main/80 flex items-center gap-3 mb-5" :class="$page?.props?.menu == 'ProductCategory' ? 'text-main/80' : ''" :href="route('productCategory.index')">
      Category
    </Link>
    <Link class="text-[14px] hover:text-main/80 flex items-center gap-3 mb-5" :class="$page?.props?.menu == 'Unit' ? 'text-main/80' : ''" :href="route('unit.index')">
      Unit
    </Link>
    <Link class="text-[14px] hover:text-main/80 flex items-center gap-3 mb-5" :class="$page?.props?.menu == 'Product' ? 'text-main/80' : ''" :href="route('product.index')">
      Product
    </Link>
    <Link class="text-[14px] hover:text-main/80 flex items-center gap-3 mb-5" :class="$page?.props?.menu == 'Supplier' ? 'text-main/80' : ''" :href="route('supplier.index')">
      Supplier
    </Link>
   
   
    
  </div>
</template>
