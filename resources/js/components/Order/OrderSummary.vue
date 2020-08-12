<template>
  <div class="OrderSummray">
    <div class="table-responsive mt-3">
      <table class="table table-hover">
        <tbody>
          <tr class="font-weight-normal">
            <td class="border-top-0">{{ $t('total_products') }}</td>
            <td class="border-top-0">{{ totalProducts }}</td>
          </tr>
          <tr class="font-weight-bold">
            <td>{{ $t('total_to_paid') }}</td>
            <td>{{ total }} zł</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  name: 'OrderSummary',
  props: {
    products: {
      type: Array,
      default: []
    },
    delivery_price: {
      default: 0
    }
  },
  computed: {
    totalProducts: function() {
      return this.products.reduce(function(total, product) {
        return total + parseInt(product.quantity);
      }, 0);
    },
    total: function () {
      return parseInt(this.delivery_price);
    }
  }
  
}
</script>