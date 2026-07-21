<?php

declare(strict_types=1);

namespace HK2\SearchSanitizer\Logger;

use Magento\Framework\Logger\Handler\Base as BaseHandler;
use Monolog\Logger;

class Handler extends BaseHandler
{
    /**
     * @param \Magento\Framework\Filesystem\DriverInterface $filesystem
     * @param string|null $filePath
     * @param string|null $fileName
     * @param int|null $loggerType
     */
    public function __construct(
        \Magento\Framework\Filesystem\DriverInterface $filesystem,
        ?string $filePath = null,
        ?string $fileName = null,
        ?int $loggerType = null
    ) {
        $fileName = $fileName ?? '/var/log/hk2-search-sanitizer.log';
        $loggerType = $loggerType ?? Logger::WARNING;
        parent::__construct($filesystem, $filePath, $fileName, $loggerType);
    }
}
