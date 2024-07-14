<div>
    <x-shared.container :breadcrumbs="$breadcrumbs">
        @if ($type == 'program')
            <livewire:accounting.pay.show-pay-program :paymentId="$payment->id" />
        @else
            <livewire:accounting.pay.show-pay-course :paymentId="$payment->id" />
        @endif
    </x-shared.container>
</div>
