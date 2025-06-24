<?php $__env->startSection('content'); ?>
<div class="py-4 px-4 sm:py-6 sm:px-0">
  <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
    <h2 class="text-xl sm:text-2xl font-bold mb-4 sm:mb-6 text-center sm:text-left">Make Contribution</h2>

    <!-- Progress Stepper -->
    <div class="mb-6 sm:mb-8">
      <div class="flex justify-between items-center">
        <div class="flex flex-col items-center">
          <div class="w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center text-sm font-medium">1</div>
          <span class="text-xs mt-1 text-center">Details</span>
        </div>
        <div class="flex-1 h-0.5 bg-gray-300 self-center mx-3 sm:mx-4"></div>
        <div class="flex flex-col items-center">
          <div class="w-8 h-8 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center text-sm font-medium">2</div>
          <span class="text-xs mt-1 text-center">Confirmation</span>
        </div>
      </div>
    </div>

    <!-- Messages Container -->
    <div id="messageContainer" aria-live="polite">
      <?php if($errors->any()): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-3 py-3 sm:px-4 rounded mb-4 text-sm" role="alert">
          <ul class="space-y-1">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </ul>
        </div>
      <?php endif; ?>
    </div>

    <!-- Contribution Form -->
    <div class="bg-white p-4 sm:p-6 rounded-lg shadow-md">
      <!-- ClickPesa Branding -->
      <div class="mb-4 flex items-center justify-center sm:justify-start gap-2">
        <img src="/images/clickpesa.jpeg" alt="ClickPesa Logo" class="h-6 sm:h-8">
        <span class="text-blue-700 font-semibold text-sm sm:text-base">Secured by ClickPesa</span>
      </div>
      
      <form id="contributionForm" x-data="contributionPaymentFlow()">
        <?php echo csrf_field(); ?>
        <!-- Amount Input -->
        <div class="mb-4 sm:mb-6">
          <label for="amount" class="block text-gray-700 text-sm font-medium mb-2">Amount (TZS)</label>
          <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-600 text-sm">TZS</span>
            <input type="number" 
                   id="amount" 
                   name="amount" 
                   x-model="amount"
                   class="w-full pl-12 pr-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-base" 
                   min="1000" 
                   max="3000000" 
                   placeholder="Enter amount"
                   required>
          </div>
          <p class="text-gray-500 text-xs sm:text-sm mt-1">Minimum: 1,000 TZS | Maximum: 3,000,000 TZS</p>
        </div>

        <!-- Phone Input -->
        <div class="mb-6">
          <label for="phone" class="block text-gray-700 text-sm font-medium mb-2">Mobile Number</label>
          <div class="relative">
            <input type="tel" 
                   id="phone" 
                   name="phone" 
                   x-model="phone"
                   class="w-full pl-4 pr-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-base" 
                   pattern="0\d{9}|255\d{9}" 
                   placeholder="0693662424 or 255693662424" 
                   title="Enter 10 digits starting with 0 or 12 digits starting with 255" 
                   required>
          </div>
          <p class="text-gray-500 text-xs sm:text-sm mt-1">Formats: 0693662424 (10 digits) or 255693662424 (12 digits)</p>
        </div>

        <?php if(auth()->guard()->check()): ?>
        <input type="hidden" name="buyer_email" x-model="buyer_email" value="<?php echo e(auth()->user()->email); ?>">
        <input type="hidden" name="buyer_name" x-model="buyer_name" value="<?php echo e(auth()->user()->name); ?>">
        <?php endif; ?>

        <button type="button" 
                @click="submitContributionPayment"
                class="w-full bg-indigo-600 text-white py-3 sm:py-4 rounded-lg font-medium hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-200 transition-colors text-base"
                x-bind:disabled="loading">
          <template x-if="!loading">Proceed to Payment</template>
          <template x-if="loading">
            <svg class="animate-spin h-5 w-5 inline text-white mr-2" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="white" stroke-width="4"></circle>
                <path class="opacity-75" fill="white" d="M4 12a8 8 0 018-8v8H4z"></path>
            </svg> Processing...
          </template>
        </button>
      </form>
    </div>
  </div>
</div>

<!-- Payment Confirmation Modal -->
<div x-show="showStkModal" x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50">
  <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-sm">
    <h3 class="text-lg font-semibold mb-4 text-center">Mock STK Push</h3>
    <p class="mb-2 text-gray-700 text-center">Enter your <span class="font-bold">Secret Key</span> to complete payment:</p>
    <input type="password" x-model="secretKey" class="w-full p-2 border border-gray-300 rounded-lg mb-4 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Secret Key">
    <div class="flex justify-between">
      <button @click="showStkModal=false" class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300">Cancel</button>
      <button @click="submitSecretKey" class="px-4 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700" x-bind:disabled="stkLoading">
        <template x-if="!stkLoading">Submit</template>
        <template x-if="stkLoading">
          <svg class="animate-spin h-5 w-5 inline text-white mr-2" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="white" stroke-width="4"></circle>
              <path class="opacity-75" fill="white" d="M4 12a8 8 0 018-8v8H4z"></path>
          </svg> Processing...
        </template>
      </button>
    </div>
  </div>
</div>

<!-- Success Modal -->
<div x-show="showSuccess" x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50">
  <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-sm text-center">
    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
      <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
      </svg>
    </div>
    <h2 class="text-xl font-semibold mb-2">Payment Successful!</h2>
    <p class="mb-4">Your contribution has been processed successfully.</p>
    <button @click="resetForm" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">Make Another Contribution</button>
  </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('head'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Use the full API base URL, trimming trailing slashes
window.backendBaseUrl = "<?php echo e(rtrim(config('app.url'), '/')); ?>";

function contributionPaymentFlow() {
  return {
    amount: '',
    phone: '',
    buyer_email: '<?php echo e(auth()->user()->email ?? ''); ?>',
    buyer_name: '<?php echo e(auth()->user()->name ?? ''); ?>',
    secretKey: '',
    loading: false,
    stkLoading: false,
    showStkModal: false,
    showSuccess: false,
    paymentData: {},
    
    // Format phone number to 255XXXXXXXXX
    formatPhone(phone) {
      let formatted = phone.trim();
      if (/^0\d{9}$/.test(formatted)) {
        return '255' + formatted.substring(1);
      }
      return formatted;
    },
    
    // Validate form inputs
    validateForm() {
      if (!this.amount || !this.phone) {
        showError('Please fill all fields');
        return false;
      }
      
      if (this.amount < 1000 || this.amount > 3000000) {
        showError('Amount must be between 1,000 and 3,000,000 TZS');
        return false;
      }
      
      const formattedPhone = this.formatPhone(this.phone);
      if (!/^255\d{9}$/.test(formattedPhone)) {
        showError('Please enter a valid phone number (10 digits starting with 0 or 12 digits starting with 255).');
        return false;
      }
      
      return true;
    },
    
    // Submit payment request
    submitContributionPayment() {
      if (!this.validateForm()) return;
      
      this.loading = true;
      const formattedPhone = this.formatPhone(this.phone);
      const isClickPesa = formattedPhone.startsWith('25574');
      
      const url = isClickPesa ? '/clickpesa/payment' : '/mpesa/payment';
      
      fetch(url, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
          'Accept': 'application/json',
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          name: this.buyer_name || 'Member',
          phone: formattedPhone,
          amount: this.amount,
          email: this.buyer_email || 'member@example.com',
        })
      })
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        return response.json();
      })
      .then(data => {
        if (isClickPesa && data.mockStkPush) {
          this.paymentData = data;
          this.showStkModal = true;
        } else if (data.ResponseCode === '0') {
          this.showSuccess = true;
        } else {
          showError(data.ResponseDescription || 'Payment initiation failed. Please try again.');
        }
      })
      .catch(error => {
        console.error('Error:', error);
        showError('Something went wrong. Please try again.');
      })
      .finally(() => {
        this.loading = false;
      });
    },
    
    // Submit secret key for mock STK
    submitSecretKey() {
      if (!this.secretKey) {
        showError('Please enter your secret key.');
        return;
      }
      
      this.stkLoading = true;
      
      // Simulate API call with timeout
      setTimeout(() => {
        this.showStkModal = false;
        this.showSuccess = true;
        this.stkLoading = false;
      }, 1200);
    },
    
    // Reset form after successful payment
    resetForm() {
      this.amount = '';
      this.phone = '';
      this.secretKey = '';
      this.showSuccess = false;
    }
  }
}

// Show error messages in the container
function showError(message) {
  const container = document.getElementById('messageContainer');
  container.innerHTML = `
    <div class="bg-red-100 border border-red-400 text-red-700 px-3 py-3 sm:px-4 rounded mb-4 text-sm" role="alert">
      ${message}
    </div>
  `;
  
  // Auto-hide error after 5 seconds
  setTimeout(() => {
    container.innerHTML = '';
  }, 5000);
}
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('styles'); ?>
<style>
  .animate-spin {
    animation: spin 1s linear infinite;
  }
  
  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
  
  [x-cloak] {
    display: none !important;
  }

  /* Enhanced mobile styling */
  @media (max-width: 640px) {
    body {
      font-size: 14px;
    }
    
    input[type="number"], input[type="tel"] {
      font-size: 16px !important;
      min-height: 44px;
    }
    
    button {
      min-height: 44px;
    }
  }

  /* Focus styles */
  input:focus, button:focus {
    outline: 2px solid transparent;
    outline-offset: 2px;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.3);
  }
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.member', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\jumuiyakiganjani\resources\views/member/contributions/create.blade.php ENDPATH**/ ?>