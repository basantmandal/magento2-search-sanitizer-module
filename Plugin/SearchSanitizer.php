<?php

declare(strict_types=1);

namespace HK2\SearchSanitizer\Plugin;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Search\Model\QueryFactory;
use Magento\Store\Model\ScopeInterface;
use Psr\Log\LoggerInterface;

class SearchSanitizer
{
    private const XML_PATH_ENABLED = 'hk2_searchsanitizer_section1/general/enabled';

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param LoggerInterface $logger
     * @param RequestInterface $request
     */
    public function __construct(
        private readonly ScopeConfigInterface $scopeConfig,
        private readonly LoggerInterface $logger,
        private readonly RequestInterface $request
    ) {
    }

    /**
     * Sanitize search query before processing.
     *
     * @param QueryFactory $subject
     * @return void
     */
    public function beforeGet(QueryFactory $subject): void
    {
        $enabled = $this->scopeConfig->isSetFlag(
            self::XML_PATH_ENABLED,
            ScopeInterface::SCOPE_STORE
        );

        if (!$enabled) {
            return;
        }

        $queryText = $this->request->getParam(QueryFactory::QUERY_VAR_NAME);

        if (is_string($queryText) && $queryText !== '') {
            $original = $queryText;

            // Sanitize the search query by removing potentially harmful SQL keywords and characters.
            $queryText = preg_replace(
                '/\b(select|insert|update|delete|drop|union(\s+all)?|truncate|alter|create|exec)\b|[;]|--|#/i',
                '',
                $queryText
            );

            // Remove any extra whitespace and trim the query.
            $queryText = preg_replace('/\s+/', ' ', $queryText);
            $queryText = trim($queryText);

            if ($original !== $queryText) {
                $this->logger->warning(
                    'Sanitized search query detected',
                    [
                        'original' => $original,
                        'sanitized' => $queryText,
                    ]
                );

                $this->request->setParams([
                    QueryFactory::QUERY_VAR_NAME => $queryText,
                ]);
            }
        }
    }
}
