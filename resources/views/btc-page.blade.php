@extends('layout.base-template', [
    'title' => ($isOnFirstPage || $isOnLastPage)
                  ? ($isOnFirstPage
                      ? 'First page of bitcoin private keys'
                      : 'Last page of bitcoin private keys')
                  : 'Bitcoin private keys'.($isShortNumberString ? ' - page '.$pageNumber : ''),

    'description' => '128 bitcoin private keys with automatic balance checker. Find a fortune on these pages filled with all bitcoin private keys.',
])

@if(! $isOnFirstPage && ! $isOnLastPage)
    @include('helpers.robots-noindex')
@endif

@section('content')

    @include('components.key-page-header', ['routeBase' => 'btcPages', 'coinName' => 'Bitcoin'])

    @if($isOnFirstPage || $isOnLastPage)
        <p class="mb-4 max-w-md mx-auto leading-normal text-center">
            @if ($isOnFirstPage)
                This is the first page of bitcoin private keys
                <br>
                This page has 128 wallets on it
            @elseif($isOnLastPage)
                This is the last page of bitcoin private keys
                <br>
                This page only has 64 wallets on it
            @endif
        </p>
    @endif

    <div class="max-w-2xl mx-auto">
    @foreach($keys as $key)
        <div id="{{ $key['wif'] }}" data-loaded="0" class="wallet loading flex flex-col lg:flex-row font-mono text-sm pl-2">

            <span class="mr-4 inline-block" style="min-width: {{ $isOnFirstPage ? '108px' : ($isOnLastPage || $pageNumber === '3' ? '100px' : '') }}">
                <strong data-balance="0" class="wallet-balance">0 btc</strong>
                <span data-tx="0" class="wallet-tx">(? tx)</span>
            </span>

            <span class="lg:mr-4 text-xs sm:text-sm break-words">{{ $key['wif'] }}</span>

            <div class="lg:block flex">
                <span class="mr-8 lg:mr-4">
                    <a href="https://blockchain.info/address/{{ $key['pub'] }}" rel="nofollow" target="_blank">
                        <span class="hidden xl:inline-block">{!! str_repeat('&nbsp;', 34 - strlen($key['pub'])) !!}{{ $key['pub'] }}</span>
                        <span class="xl:hidden inline-block">public key</span>
                    </a>
                </span>
                <span>
                    <a href="https://blockchain.info/address/{{ $key['cpub'] }}" rel="nofollow" target="_blank">
                        <span class="hidden xl:inline-block">{{ $key['cpub'] }}</span>
                        <span class="xl:hidden inline-block">compressed public key</span>
                    </a>
                </span>
            </div>

        </div>
    @endforeach
    </div>

    <div class="mt-8 mb-6">
        @include('components.key-page-pagination', ['routeBase' => 'btcPages', 'includeFirstAndLast' => false])
    </div>

@endsection

@push('footer')
    <script>
        const keys = @json($keys);
        const isOnFirstPage = @json($isOnFirstPage);
        const isOnLastPage = @json($isOnLastPage);
    </script>

    <script type="text/javascript" src="{{ mix('js/bitcoin-page.js') }}"></script>
@endpush