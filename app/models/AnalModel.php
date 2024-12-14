<?php
class AnalModel extends Model
{
    public function getDashboardData($tenantId, $startDate, $endDate)
    {
        if (strtotime($startDate) === false || strtotime($endDate) === false) {
            error_log("Invalid date format for startDate or endDate");
            return false;
        }

        // SQL query for total orders
        $sqlOrders = "
        SELECT NVL(COUNT(td.id_transaction), 0) AS TOTAL_ORDERS
        FROM TRANSACTION t
        JOIN TRANSACTION_DETAIL td ON t.id_transaction = td.id_transaction
        JOIN MENU m ON td.id_menu = m.id_menu
        WHERE m.id_tenant = :tenantId
        AND t.trx_date BETWEEN TO_DATE(:startDate, 'DD-MM-YYYY') AND TO_DATE(:endDate, 'DD-MM-YYYY')
    ";

        // Execute the query for total orders
        $this->db->query($sqlOrders);
        $this->db->bindObject(':tenantId', $tenantId);
        $this->db->bindObject(':startDate', $startDate);
        $this->db->bindObject(':endDate', $endDate);
        $ordersResult = $this->db->single(PDO::FETCH_OBJ);  // Explicitly fetch as object
        $totalOrders = isset($ordersResult->TOTAL_ORDERS) ? (int)$ordersResult->TOTAL_ORDERS : 0;

        // SQL query for total revenue
        $sqlRevenue = "
        SELECT NVL(SUM(td.qty_price + td.pkg_price), 0) AS TOTAL_REVENUE
        FROM TRANSACTION t
        JOIN TRANSACTION_DETAIL td ON t.id_transaction = td.id_transaction
        JOIN MENU m ON td.id_menu = m.id_menu
        WHERE m.id_tenant = :tenantId
        AND t.trx_date BETWEEN TO_DATE(:startDate, 'DD-MM-YYYY') AND TO_DATE(:endDate, 'DD-MM-YYYY')
    ";

        // Execute the query for total revenue
        $this->db->query($sqlRevenue);
        $this->db->bindObject(':tenantId', $tenantId);
        $this->db->bindObject(':startDate', $startDate);
        $this->db->bindObject(':endDate', $endDate);
        $revenueResult = $this->db->single(PDO::FETCH_OBJ);  
        $totalRevenue = isset($revenueResult->TOTAL_REVENUE) ? (float)$revenueResult->TOTAL_REVENUE : 0;

        // SQL query for daily revenue for chart
        $sqlRevenuePerDay = "
        SELECT TO_CHAR(t.trx_date, 'DD-MM-YYYY') AS trx_date,
               NVL(SUM(td.qty_price + td.pkg_price), 0) AS total_revenue
        FROM TRANSACTION t
        JOIN TRANSACTION_DETAIL td ON t.id_transaction = td.id_transaction
        JOIN MENU m ON td.id_menu = m.id_menu
        WHERE m.id_tenant = :tenantId
        AND t.trx_date BETWEEN TO_DATE(:startDate, 'DD-MM-YYYY') AND TO_DATE(:endDate, 'DD-MM-YYYY')
        GROUP BY TO_CHAR(t.trx_date, 'DD-MM-YYYY')
        ORDER BY trx_date
    ";

        // Execute the query for daily revenue
        $this->db->query($sqlRevenuePerDay);
        $this->db->bindObject(':tenantId', $tenantId);
        $this->db->bindObject(':startDate', $startDate);
        $this->db->bindObject(':endDate', $endDate);
        $revenuePerDayResults = $this->db->resultSet(PDO::FETCH_OBJ);  

        $chartLabels = [];
        $chartData = [];

        if (!empty($revenuePerDayResults)) {
            foreach ($revenuePerDayResults as $result) {
                $chartLabels[] = $result->trx_date;
                $chartData[] = (float)$result->total_revenue;
            }
        }

        return [
            'totalOrders' => $totalOrders,
            'totalRevenue' => $totalRevenue,
            'chartLabels' => $chartLabels,
            'chartData' => $chartData,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ];
    }
}
