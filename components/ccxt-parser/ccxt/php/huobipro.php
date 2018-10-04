<?php

namespace ccxt;

// PLEASE DO NOT EDIT THIS FILE, IT IS GENERATED AND WILL BE OVERWRITTEN:
// https://github.com/ccxt/ccxt/blob/master/CONTRIBUTING.md#how-to-contribute-code

use Exception as Exception; // a common import

class huobipro extends Exchange {

    public function describe () {
        return array_replace_recursive (parent::describe (), array (
            'id' => 'huobipro',
            'name' => 'Huobi Pro',
            'countries' => array ( 'CN' ),
            'rateLimit' => 2000,
            'userAgent' => $this->userAgents['chrome39'],
            'version' => 'v1',
            'accounts' => null,
            'accountsById' => null,
            'hostname' => 'api.huobi.pro',
            'has' => array (
                'CORS' => false,
                'fetchDepositAddress' => true,
                'fetchOHLCV' => true,
                'fetchOpenOrders' => true,
                'fetchClosedOrders' => true,
                'fetchOrder' => true,
                'fetchOrders' => false,
                'fetchTradingLimits' => true,
                'withdraw' => true,
                'fetchCurrencies' => true,
            ),
            'timeframes' => array (
                '1m' => '1min',
                '5m' => '5min',
                '15m' => '15min',
                '30m' => '30min',
                '1h' => '60min',
                '1d' => '1day',
                '1w' => '1week',
                '1M' => '1mon',
                '1y' => '1year',
            ),
            'urls' => array (
                'logo' => 'https://user-images.githubusercontent.com/1294454/27766569-15aa7b9a-5edd-11e7-9e7f-44791f4ee49c.jpg',
                'api' => 'https://api.huobi.pro',
                'www' => 'https://www.huobi.pro',
                'referral' => 'https://www.huobi.br.com/en-us/topic/invited/?invite_code=rwrd3',
                'doc' => 'https://github.com/huobiapi/API_Docs/wiki/REST_api_reference',
                'fees' => 'https://www.huobi.pro/about/fee/',
            ),
            'api' => array (
                'market' => array (
                    'get' => array (
                        'history/kline', // 获取K线数据
                        'detail/merged', // 获取聚合行情(Ticker)
                        'depth', // 获取 Market Depth 数据
                        'trade', // 获取 Trade Detail 数据
                        'history/trade', // 批量获取最近的交易记录
                        'detail', // 获取 Market Detail 24小时成交量数据
                    ),
                ),
                'public' => array (
                    'get' => array (
                        'common/symbols', // 查询系统支持的所有交易对
                        'common/currencys', // 查询系统支持的所有币种
                        'common/timestamp', // 查询系统当前时间
                        'common/exchange', // order limits
                        'settings/currencys', // ?language=en-US
                    ),
                ),
                'private' => array (
                    'get' => array (
                        'account/accounts', // 查询当前用户的所有账户(即account-id)
                        'account/accounts/{id}/balance', // 查询指定账户的余额
                        'order/orders/{id}', // 查询某个订单详情
                        'order/orders/{id}/matchresults', // 查询某个订单的成交明细
                        'order/orders', // 查询当前委托、历史委托
                        'order/matchresults', // 查询当前成交、历史成交
                        'dw/withdraw-virtual/addresses', // 查询虚拟币提现地址
                        'dw/deposit-virtual/addresses',
                        'query/deposit-withdraw',
                        'margin/loan-orders', // 借贷订单
                        'margin/accounts/balance', // 借贷账户详情
                    ),
                    'post' => array (
                        'order/orders/place', // 创建并执行一个新订单 (一步下单， 推荐使用)
                        'order/orders', // 创建一个新的订单请求 （仅创建订单，不执行下单）
                        'order/orders/{id}/place', // 执行一个订单 （仅执行已创建的订单）
                        'order/orders/{id}/submitcancel', // 申请撤销一个订单请求
                        'order/orders/batchcancel', // 批量撤销订单
                        'dw/balance/transfer', // 资产划转
                        'dw/withdraw/api/create', // 申请提现虚拟币
                        'dw/withdraw-virtual/create', // 申请提现虚拟币
                        'dw/withdraw-virtual/{id}/place', // 确认申请虚拟币提现
                        'dw/withdraw-virtual/{id}/cancel', // 申请取消提现虚拟币
                        'dw/transfer-in/margin', // 现货账户划入至借贷账户
                        'dw/transfer-out/margin', // 借贷账户划出至现货账户
                        'margin/orders', // 申请借贷
                        'margin/orders/{id}/repay', // 归还借贷
                    ),
                ),
            ),
            'fees' => array (
                'trading' => array (
                    'tierBased' => false,
                    'percentage' => true,
                    'maker' => 0.002,
                    'taker' => 0.002,
                ),
            ),
            'exceptions' => array (
                'account-frozen-balance-insufficient-error' => '\\ccxt\\InsufficientFunds', // array ("status":"error","err-code":"account-frozen-balance-insufficient-error","err-msg":"trade account balance is not enough, left => `0.0027`","data":null)
                'order-limitorder-amount-min-error' => '\\ccxt\\InvalidOrder', // limit order amount error, min => `0.001`
                'order-marketorder-amount-min-error' => '\\ccxt\\InvalidOrder', // market order amount error, min => `0.01`
                'order-limitorder-price-min-error' => '\\ccxt\\InvalidOrder', // limit order price error
                'order-orderstate-error' => '\\ccxt\\OrderNotFound', // canceling an already canceled order
                'order-queryorder-invalid' => '\\ccxt\\OrderNotFound', // querying a non-existent order
                'order-update-error' => '\\ccxt\\ExchangeNotAvailable', // undocumented error
                'api-signature-check-failed' => '\\ccxt\\AuthenticationError',
            ),
            'options' => array (
                'createMarketBuyOrderRequiresPrice' => true,
                'fetchMarketsMethod' => 'publicGetCommonSymbols',
                'fetchBalanceMethod' => 'privateGetAccountAccountsIdBalance',
                'createOrderMethod' => 'privatePostOrderOrdersPlace',
                'language' => 'en-US',
            ),
        ));
    }

    public function fetch_trading_limits ($symbols = null, $params = array ()) {
        //  by default it will try load withdrawal fees of all currencies (with separate requests)
        //  however if you define codes = array ( 'ETH', 'BTC' ) in args it will only load those
        $this->load_markets();
        $info = array ();
        $limits = array ();
        if ($symbols === null)
            $symbols = $this->symbols;
        for ($i = 0; $i < count ($symbols); $i++) {
            $symbol = $symbols[$i];
            $market = $this->market ($symbol);
            $response = $this->publicGetCommonExchange (array_merge (array (
                'symbol' => $market['id'],
            )));
            $limit = $this->parse_trading_limits ($response);
            $info[$symbol] = $response;
            $limits[$symbol] = $limit;
        }
        return array (
            'limits' => $limits,
            'info' => $info,
        );
    }

    public function parse_trading_limits ($response, $symbol = null, $params = array ()) {
        $data = $response['data'];
        if ($data === null) {
            return null;
        }
        return array (
            'amount' => array (
                'min' => $data['limit-order-must-greater-than'],
                'max' => $data['limit-order-must-less-than'],
            ),
        );
    }

    public function fetch_markets () {
        $method = $this->options['fetchMarketsMethod'];
        $response = $this->$method ();
        $markets = $response['data'];
        $numMarkets = is_array ($markets) ? count ($markets) : 0;
        if ($numMarkets < 1)
            throw new ExchangeError ($this->id . ' publicGetCommonSymbols returned empty $response => ' . $this->json ($markets));
        $result = array ();
        for ($i = 0; $i < count ($markets); $i++) {
            $market = $markets[$i];
            $baseId = $market['base-currency'];
            $quoteId = $market['quote-currency'];
            $base = strtoupper ($baseId);
            $quote = strtoupper ($quoteId);
            $id = $baseId . $quoteId;
            $base = $this->common_currency_code($base);
            $quote = $this->common_currency_code($quote);
            $symbol = $base . '/' . $quote;
            $precision = array (
                'amount' => $market['amount-precision'],
                'price' => $market['price-precision'],
            );
            $lot = pow (10, -$precision['amount']);
            $maker = ($base === 'OMG') ? 0 : 0.2 / 100;
            $taker = ($base === 'OMG') ? 0 : 0.2 / 100;
            $result[] = array (
                'id' => $id,
                'symbol' => $symbol,
                'base' => $base,
                'quote' => $quote,
                'lot' => $lot,
                'active' => true,
                'precision' => $precision,
                'taker' => $taker,
                'maker' => $maker,
                'limits' => array (
                    'amount' => array (
                        'min' => $lot,
                        'max' => pow (10, $precision['amount']),
                    ),
                    'price' => array (
                        'min' => pow (10, -$precision['price']),
                        'max' => null,
                    ),
                    'cost' => array (
                        'min' => 0,
                        'max' => null,
                    ),
                ),
                'info' => $market,
            );
        }
        return $result;
    }

    public function parse_ticker ($ticker, $market = null) {
        $symbol = null;
        if ($market)
            $symbol = $market['symbol'];
        $timestamp = $this->milliseconds ();
        if (is_array ($ticker) && array_key_exists ('ts', $ticker))
            $timestamp = $ticker['ts'];
        $bid = null;
        $ask = null;
        $bidVolume = null;
        $askVolume = null;
        if (is_array ($ticker) && array_key_exists ('bid', $ticker)) {
            if (gettype ($ticker['bid']) === 'array' && count (array_filter (array_keys ($ticker['bid']), 'is_string')) == 0) {
                $bid = $this->safe_float($ticker['bid'], 0);
                $bidVolume = $this->safe_float($ticker['bid'], 1);
            }
        }
        if (is_array ($ticker) && array_key_exists ('ask', $ticker)) {
            if (gettype ($ticker['ask']) === 'array' && count (array_filter (array_keys ($ticker['ask']), 'is_string')) == 0) {
                $ask = $this->safe_float($ticker['ask'], 0);
                $askVolume = $this->safe_float($ticker['ask'], 1);
            }
        }
        $open = $this->safe_float($ticker, 'open');
        $close = $this->safe_float($ticker, 'close');
        $change = null;
        $percentage = null;
        $average = null;
        if (($open !== null) && ($close !== null)) {
            $change = $close - $open;
            $average = $this->sum ($open, $close) / 2;
            if (($close !== null) && ($close > 0))
                $percentage = ($change / $open) * 100;
        }
        $baseVolume = $this->safe_float($ticker, 'amount');
        $quoteVolume = $this->safe_float($ticker, 'vol');
        $vwap = null;
        if ($baseVolume !== null && $quoteVolume !== null && $baseVolume > 0)
            $vwap = $quoteVolume / $baseVolume;
        return array (
            'symbol' => $symbol,
            'timestamp' => $timestamp,
            'datetime' => $this->iso8601 ($timestamp),
            'high' => $ticker['high'],
            'low' => $ticker['low'],
            'bid' => $bid,
            'bidVolume' => $bidVolume,
            'ask' => $ask,
            'askVolume' => $askVolume,
            'vwap' => $vwap,
            'open' => $open,
            'close' => $close,
            'last' => $close,
            'previousClose' => null,
            'change' => $change,
            'percentage' => $percentage,
            'average' => $average,
            'baseVolume' => $baseVolume,
            'quoteVolume' => $quoteVolume,
            'info' => $ticker,
        );
    }

    public function fetch_order_book ($symbol, $limit = null, $params = array ()) {
        $this->load_markets();
        $market = $this->market ($symbol);
        $response = $this->marketGetDepth (array_merge (array (
            'symbol' => $market['id'],
            'type' => 'step0',
        ), $params));
        if (is_array ($response) && array_key_exists ('tick', $response)) {
            if (!$response['tick']) {
                throw new ExchangeError ($this->id . ' fetchOrderBook() returned empty $response => ' . $this->json ($response));
            }
            $orderbook = $response['tick'];
            $timestamp = $orderbook['ts'];
            $orderbook['nonce'] = $orderbook['version'];
            return $this->parse_order_book($orderbook, $timestamp);
        }
        throw new ExchangeError ($this->id . ' fetchOrderBook() returned unrecognized $response => ' . $this->json ($response));
    }

    public function fetch_ticker ($symbol, $params = array ()) {
        $this->load_markets();
        $market = $this->market ($symbol);
        $response = $this->marketGetDetailMerged (array_merge (array (
            'symbol' => $market['id'],
        ), $params));
        return $this->parse_ticker($response['tick'], $market);
    }

    public function parse_trade ($trade, $market) {
        $timestamp = $trade['ts'];
        return array (
            'info' => $trade,
            'id' => (string) $trade['id'],
            'order' => null,
            'timestamp' => $timestamp,
            'datetime' => $this->iso8601 ($timestamp),
            'symbol' => $market['symbol'],
            'type' => null,
            'side' => $trade['direction'],
            'price' => $trade['price'],
            'amount' => $trade['amount'],
        );
    }

    public function fetch_trades ($symbol, $since = null, $limit = 1000, $params = array ()) {
        $this->load_markets();
        $market = $this->market ($symbol);
        $request = array (
            'symbol' => $market['id'],
        );
        if ($limit !== null)
            $request['size'] = $limit;
        $response = $this->marketGetHistoryTrade (array_merge ($request, $params));
        $data = $response['data'];
        $result = array ();
        for ($i = 0; $i < count ($data); $i++) {
            $trades = $data[$i]['data'];
            for ($j = 0; $j < count ($trades); $j++) {
                $trade = $this->parse_trade($trades[$j], $market);
                $result[] = $trade;
            }
        }
        $result = $this->sort_by($result, 'timestamp');
        return $this->filter_by_symbol_since_limit($result, $symbol, $since, $limit);
    }

    public function parse_ohlcv ($ohlcv, $market = null, $timeframe = '1m', $since = null, $limit = null) {
        return [
            $ohlcv['id'] * 1000,
            $ohlcv['open'],
            $ohlcv['high'],
            $ohlcv['low'],
            $ohlcv['close'],
            $ohlcv['amount'],
        ];
    }

    public function fetch_ohlcv ($symbol, $timeframe = '1m', $since = null, $limit = 1000, $params = array ()) {
        $this->load_markets();
        $market = $this->market ($symbol);
        $request = array (
            'symbol' => $market['id'],
            'period' => $this->timeframes[$timeframe],
        );
        if ($limit !== null) {
            $request['size'] = $limit;
        }
        $response = $this->marketGetHistoryKline (array_merge ($request, $params));
        return $this->parse_ohlcvs($response['data'], $market, $timeframe, $since, $limit);
    }

    public function load_accounts ($reload = false) {
        if ($reload) {
            $this->accounts = $this->fetch_accounts ();
        } else {
            if ($this->accounts) {
                return $this->accounts;
            } else {
                $this->accounts = $this->fetch_accounts ();
                $this->accountsById = $this->index_by($this->accounts, 'id');
            }
        }
        return $this->accounts;
    }

    public function fetch_accounts () {
        $this->load_markets();
        $response = $this->privateGetAccountAccounts ();
        return $response['data'];
    }

    public function fetch_currencies ($params = array ()) {
        $response = $this->publicGetSettingsCurrencys (array_merge (array (
            'language' => $this->options['language'],
        ), $params));
        $currencies = $response['data'];
        $result = array ();
        for ($i = 0; $i < count ($currencies); $i++) {
            $currency = $currencies[$i];
            //
            //  {                     name => "ctxc",
            //              'display-name' => "CTXC",
            //        'withdraw-precision' =>  8,
            //             'currency-type' => "eth",
            //        'currency-partition' => "pro",
            //             'support-sites' =>  null,
            //                'otc-enable' =>  0,
            //        'deposit-min-amount' => "2",
            //       'withdraw-min-amount' => "4",
            //            'show-precision' => "8",
            //                      weight => "2988",
            //                     visible =>  true,
            //              'deposit-desc' => "Please don’t deposit any other digital assets except CTXC t…",
            //             'withdraw-desc' => "Minimum withdrawal amount => 4 CTXC. !>_<!For security reason…",
            //           'deposit-enabled' =>  true,
            //          'withdraw-enabled' =>  true,
            //    'currency-addr-with-tag' =>  false,
            //             'fast-confirms' =>  15,
            //             'safe-confirms' =>  30                                                             }
            //
            $id = $this->safe_value($currency, 'name');
            $precision = $this->safe_integer($currency, 'withdraw-precision');
            $code = $this->common_currency_code(strtoupper ($id));
            $active = $currency['visible'] && $currency['deposit-enabled'] && $currency['withdraw-enabled'];
            $result[$code] = array (
                'id' => $id,
                'code' => $code,
                'type' => 'crypto',
                // 'payin' => $currency['deposit-enabled'],
                // 'payout' => $currency['withdraw-enabled'],
                // 'transfer' => null,
                'name' => $currency['display-name'],
                'active' => $active,
                'fee' => null, // todo need to fetch from fee endpoint
                'precision' => $precision,
                'limits' => array (
                    'amount' => array (
                        'min' => pow (10, -$precision),
                        'max' => pow (10, $precision),
                    ),
                    'price' => array (
                        'min' => pow (10, -$precision),
                        'max' => pow (10, $precision),
                    ),
                    'cost' => array (
                        'min' => null,
                        'max' => null,
                    ),
                    'deposit' => array (
                        'min' => $this->safe_float($currency, 'deposit-min-amount'),
                        'max' => pow (10, $precision),
                    ),
                    'withdraw' => array (
                        'min' => $this->safe_float($currency, 'withdraw-min-amount'),
                        'max' => pow (10, $precision),
                    ),
                ),
                'info' => $currency,
            );
        }
        return $result;
    }

    public function fetch_balance ($params = array ()) {
        $this->load_markets();
        $this->load_accounts ();
        $method = $this->options['fetchBalanceMethod'];
        $response = $this->$method (array_merge (array (
            'id' => $this->accounts[0]['id'],
        ), $params));
        $balances = $response['data']['list'];
        $result = array ( 'info' => $response );
        for ($i = 0; $i < count ($balances); $i++) {
            $balance = $balances[$i];
            $uppercase = strtoupper ($balance['currency']);
            $currency = $this->common_currency_code($uppercase);
            $account = null;
            if (is_array ($result) && array_key_exists ($currency, $result))
                $account = $result[$currency];
            else
                $account = $this->account ();
            if ($balance['type'] === 'trade')
                $account['free'] = floatval ($balance['balance']);
            if ($balance['type'] === 'frozen')
                $account['used'] = floatval ($balance['balance']);
            $account['total'] = $this->sum ($account['free'], $account['used']);
            $result[$currency] = $account;
        }
        return $this->parse_balance($result);
    }

    public function fetch_orders_by_states ($states, $symbol = null, $since = null, $limit = null, $params = array ()) {
        if (!$symbol)
            throw new ExchangeError ($this->id . ' fetchOrders() requires a $symbol parameter');
        $this->load_markets();
        $market = $this->market ($symbol);
        $response = $this->privateGetOrderOrders (array_merge (array (
            'symbol' => $market['id'],
            'states' => $states,
        ), $params));
        return $this->parse_orders($response['data'], $market, $since, $limit);
    }

    public function fetch_orders ($symbol = null, $since = null, $limit = null, $params = array ()) {
        return $this->fetch_orders_by_states ('pre-submitted,submitted,partial-filled,filled,partial-canceled,canceled', $symbol, $since, $limit, $params);
    }

    public function fetch_open_orders ($symbol = null, $since = null, $limit = null, $params = array ()) {
        return $this->fetch_orders_by_states ('pre-submitted,submitted,partial-filled', $symbol, $since, $limit, $params);
    }

    public function fetch_closed_orders ($symbol = null, $since = null, $limit = null, $params = array ()) {
        return $this->fetch_orders_by_states ('filled,partial-canceled,canceled', $symbol, $since, $limit, $params);
    }

    public function fetch_order ($id, $symbol = null, $params = array ()) {
        $this->load_markets();
        $response = $this->privateGetOrderOrdersId (array_merge (array (
            'id' => $id,
        ), $params));
        return $this->parse_order($response['data']);
    }

    public function parse_order_status ($status) {
        if ($status === 'partial-filled') {
            return 'open';
        } else if ($status === 'partial-canceled') {
            return 'canceled';
        } else if ($status === 'filled') {
            return 'closed';
        } else if ($status === 'canceled') {
            return 'canceled';
        } else if ($status === 'submitted') {
            return 'open';
        }
        return $status;
    }

    public function parse_order ($order, $market = null) {
        $side = null;
        $type = null;
        $status = null;
        if (is_array ($order) && array_key_exists ('type', $order)) {
            $orderType = explode ('-', $order['type']);
            $side = $orderType[0];
            $type = $orderType[1];
            $status = $this->parse_order_status($order['state']);
        }
        $symbol = null;
        if ($market === null) {
            if (is_array ($order) && array_key_exists ('symbol', $order)) {
                if (is_array ($this->markets_by_id) && array_key_exists ($order['symbol'], $this->markets_by_id)) {
                    $marketId = $order['symbol'];
                    $market = $this->markets_by_id[$marketId];
                }
            }
        }
        if ($market)
            $symbol = $market['symbol'];
        $timestamp = $order['created-at'];
        $amount = $this->safe_float($order, 'amount');
        $filled = floatval ($order['field-amount']);
        $remaining = $amount - $filled;
        $price = $this->safe_float($order, 'price');
        $cost = floatval ($order['field-cash-amount']);
        $average = 0;
        if ($filled)
            $average = floatval ($cost / $filled);
        $result = array (
            'info' => $order,
            'id' => (string) $order['id'],
            'timestamp' => $timestamp,
            'datetime' => $this->iso8601 ($timestamp),
            'lastTradeTimestamp' => null,
            'symbol' => $symbol,
            'type' => $type,
            'side' => $side,
            'price' => $price,
            'average' => $average,
            'cost' => $cost,
            'amount' => $amount,
            'filled' => $filled,
            'remaining' => $remaining,
            'status' => $status,
            'fee' => null,
        );
        return $result;
    }

    public function create_order ($symbol, $type, $side, $amount, $price = null, $params = array ()) {
        $this->load_markets();
        $this->load_accounts ();
        $market = $this->market ($symbol);
        $order = array (
            'account-id' => $this->accounts[0]['id'],
            'amount' => $this->amount_to_precision($symbol, $amount),
            'symbol' => $market['id'],
            'type' => $side . '-' . $type,
        );
        if ($this->options['createMarketBuyOrderRequiresPrice']) {
            if (($type === 'market') && ($side === 'buy')) {
                if ($price === null) {
                    throw new InvalidOrder ($this->id . " $market buy $order requires $price argument to calculate cost (total $amount of quote currency to spend for buying, $amount * $price). To switch off this warning exception and specify cost in the $amount argument, set .options['createMarketBuyOrderRequiresPrice'] = false. Make sure you know what you're doing.");
                } else {
                    $order['amount'] = $this->price_to_precision($symbol, floatval ($amount) * floatval ($price));
                }
            }
        }
        if ($type === 'limit')
            $order['price'] = $this->price_to_precision($symbol, $price);
        $method = $this->options['createOrderMethod'];
        $response = $this->$method (array_merge ($order, $params));
        $timestamp = $this->milliseconds ();
        return array (
            'info' => $response,
            'id' => $response['data'],
            'timestamp' => $timestamp,
            'datetime' => $this->iso8601 ($timestamp),
            'lastTradeTimestamp' => null,
            'status' => null,
            'symbol' => $symbol,
            'type' => $type,
            'side' => $side,
            'price' => $price,
            'amount' => $amount,
            'filled' => null,
            'remaining' => null,
            'cost' => null,
            'trades' => null,
            'fee' => null,
        );
    }

    public function cancel_order ($id, $symbol = null, $params = array ()) {
        return $this->privatePostOrderOrdersIdSubmitcancel (array ( 'id' => $id ));
    }

    public function fetch_deposit_address ($code, $params = array ()) {
        $this->load_markets();
        $currency = $this->currency ($code);
        $response = $this->privateGetDwDepositVirtualAddresses (array_merge (array (
            'currency' => strtolower ($currency['id']),
        ), $params));
        $address = $this->safe_string($response, 'data');
        $this->check_address($address);
        return array (
            'currency' => $code,
            'address' => $address,
            'info' => $response,
        );
    }

    public function fee_to_precision ($currency, $fee) {
        return floatval ($this->decimal_to_precision($fee, 0, $this->currencies[$currency]['precision']));
    }

    public function calculate_fee ($symbol, $type, $side, $amount, $price, $takerOrMaker = 'taker', $params = array ()) {
        $market = $this->markets[$symbol];
        $rate = $market[$takerOrMaker];
        $cost = $amount * $rate;
        $key = 'quote';
        if ($side === 'sell') {
            $cost *= $price;
        } else {
            $key = 'base';
        }
        return array (
            'type' => $takerOrMaker,
            'currency' => $market[$key],
            'rate' => $rate,
            'cost' => floatval ($this->fee_to_precision($market[$key], $cost)),
        );
    }

    public function withdraw ($code, $amount, $address, $tag = null, $params = array ()) {
        $this->load_markets();
        $this->check_address($address);
        $currency = $this->currency ($code);
        $request = array (
            'address' => $address, // only supports existing addresses in your withdraw $address list
            'amount' => $amount,
            'currency' => strtolower ($currency['id']),
        );
        if ($tag !== null)
            $request['addr-tag'] = $tag; // only for XRP?
        $response = $this->privatePostDwWithdrawApiCreate (array_merge ($request, $params));
        $id = null;
        if (is_array ($response) && array_key_exists ('data', $response)) {
            $id = $response['data'];
        }
        return array (
            'info' => $response,
            'id' => $id,
        );
    }

    public function sign ($path, $api = 'public', $method = 'GET', $params = array (), $headers = null, $body = null) {
        $url = '/';
        if ($api === 'market')
            $url .= $api;
        else
            $url .= $this->version;
        $url .= '/' . $this->implode_params($path, $params);
        $query = $this->omit ($params, $this->extract_params($path));
        if ($api === 'private') {
            $this->check_required_credentials();
            $timestamp = $this->ymdhms ($this->milliseconds (), 'T');
            $request = $this->keysort (array_merge (array (
                'SignatureMethod' => 'HmacSHA256',
                'SignatureVersion' => '2',
                'AccessKeyId' => $this->apiKey,
                'Timestamp' => $timestamp,
            ), $query));
            $auth = $this->urlencode ($request);
            // unfortunately, PHP demands double quotes for the escaped newline symbol
            // eslint-disable-next-line quotes
            $payload = implode ("\n", array ($method, $this->hostname, $url, $auth));
            $signature = $this->hmac ($this->encode ($payload), $this->encode ($this->secret), 'sha256', 'base64');
            $auth .= '&' . $this->urlencode (array ( 'Signature' => $signature ));
            $url .= '?' . $auth;
            if ($method === 'POST') {
                $body = $this->json ($query);
                $headers = array (
                    'Content-Type' => 'application/json',
                );
            } else {
                $headers = array (
                    'Content-Type' => 'application/x-www-form-urlencoded',
                );
            }
        } else {
            if ($params)
                $url .= '?' . $this->urlencode ($params);
        }
        $url = $this->urls['api'] . $url;
        return array ( 'url' => $url, 'method' => $method, 'body' => $body, 'headers' => $headers );
    }

    public function handle_errors ($httpCode, $reason, $url, $method, $headers, $body) {
        if (gettype ($body) !== 'string')
            return; // fallback to default error handler
        if (strlen ($body) < 2)
            return; // fallback to default error handler
        if (($body[0] === '{') || ($body[0] === '[')) {
            $response = json_decode ($body, $as_associative_array = true);
            if (is_array ($response) && array_key_exists ('status', $response)) {
                //
                //     array ("$status":"error","err-$code":"order-limitorder-amount-min-error","err-msg":"limit order amount error, min => `0.001`","data":null)
                //
                $status = $this->safe_string($response, 'status');
                if ($status === 'error') {
                    $code = $this->safe_string($response, 'err-code');
                    $feedback = $this->id . ' ' . $this->json ($response);
                    $exceptions = $this->exceptions;
                    if (is_array ($exceptions) && array_key_exists ($code, $exceptions)) {
                        throw new $exceptions[$code] ($feedback);
                    }
                    throw new ExchangeError ($feedback);
                }
            }
        }
    }
}