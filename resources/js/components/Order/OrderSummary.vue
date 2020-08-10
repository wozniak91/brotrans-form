<template>
  <div class="OrderSummray">
    <div class="table-responsive mt-3">
      <table class="table table-hover">
        <tbody>
          <tr class="font-weight-normal">
            <td class="border-top-0">{{ $t('delivery_price') }}</td>
            <td class="border-top-0">{{ delivery_price }} zł</td>
          </tr>
          <tr class="font-weight-normal">
            <td>{{ $t('total_products') }}</td>
            <td>{{ totalProducts }} zł</td>
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
      let total = 0;
      this.products.map(product => {
        total += parseInt(product.price_brutto)*parseInt(product.quantity)
      })

      return total;
    },
    total: function () {
      let total = parseInt(this.delivery_price);

      this.products.map(product => {
        total += parseInt(product.price_brutto)*parseInt(product.quantity)
      })

      return total;
    }
  }
  
}
</script>