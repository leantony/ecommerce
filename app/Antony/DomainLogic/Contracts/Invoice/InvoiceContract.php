<?php namespace app\Antony\DomainLogic\Contracts\Invoice;

interface InvoiceContract
{


    const NO_DATA_FOR_INVOICE = 'invoice.empty.data';

    const INVOICE_SENT = 'invoice.sent';

    const INVOICE_CREATED = 'invoice.created';

    /**
     * @return mixed
     */
    public function sendInvoice();

    /**
     * @param bool $sendNow
     *
     * @return mixed
     */
    public function createInvoice($sendNow = false);

    /**
     * @param $order_id
     *
     * @return mixed
     */
    public function retrieveOrderInvoice($order_id);
}