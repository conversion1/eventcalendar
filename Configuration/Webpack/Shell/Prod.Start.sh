#/bin/bash
echo "Removing TYPO3 Content from .htaccess"
sed -i '/SetEnv TYPO3_CONTEXT Development\/EventsDev/d' ../../../.htaccess