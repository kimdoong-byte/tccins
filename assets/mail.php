<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $recipient = "sales@tccins.co.kr";

    $solution      = isset($_POST["solution"])      ? trim($_POST["solution"])      : "";
    $company_name  = isset($_POST["company_name"])  ? trim($_POST["company_name"])  : "";
    $phone         = isset($_POST["phone"])          ? trim($_POST["phone"])         : "";
    $message       = isset($_POST["message"])        ? trim($_POST["message"])       : "";
    $name          = isset($_POST["name"])           ? trim($_POST["name"])          : "";
    $email         = isset($_POST["email"])          ? trim($_POST["email"])         : "";
    $position      = isset($_POST["position"])       ? trim($_POST["position"])      : "";
    $industry      = isset($_POST["industry"])       ? trim($_POST["industry"])      : "";
    $employee_count = isset($_POST["employee_count"]) ? trim($_POST["employee_count"]) : "";
    $referral_source = isset($_POST["referral_source"]) ? trim($_POST["referral_source"]) : "";

    if (empty($company_name) || empty($phone) || empty($message)) {
        http_response_code(400);
        echo "필수 항목을 모두 입력해주세요.";
        exit;
    }

    $subject = "[TCC INS 문의] " . ($solution ? $solution . " 문의" : "솔루션 문의") . " - " . $company_name;

    $email_content  = "===== TCC INS 문의 접수 =====\n\n";
    $email_content .= "관심 솔루션 : " . ($solution ?: "-") . "\n";
    $email_content .= "회사명      : " . $company_name . "\n";
    $email_content .= "연락처      : " . $phone . "\n";
    if ($name)           $email_content .= "성명        : " . $name . "\n";
    if ($email)          $email_content .= "이메일      : " . $email . "\n";
    if ($position)       $email_content .= "직급        : " . $position . "\n";
    if ($industry)       $email_content .= "업종        : " . $industry . "\n";
    if ($employee_count) $email_content .= "직원수      : " . $employee_count . "명\n";
    if ($referral_source) $email_content .= "유입경로    : " . $referral_source . "\n";
    $email_content .= "\n문의 내용 :\n" . $message . "\n";
    $email_content .= "\n==============================\n";

    $headers  = "From: TCC INS 문의 <noreply@tccins.co.kr>\r\n";
    $headers .= "Reply-To: " . ($email ?: $recipient) . "\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    if (mail($recipient, $subject, $email_content, $headers)) {
        http_response_code(200);
        echo "success";
    } else {
        http_response_code(500);
        echo "메일 발송에 실패했습니다. 잠시 후 다시 시도해주세요.";
    }

} else {
    http_response_code(403);
    echo "잘못된 요청입니다.";
}
?>
