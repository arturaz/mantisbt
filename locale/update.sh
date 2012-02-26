#!/bin/sh
cd ..
for f in locale/* ; do
	if [ -d "$f" ]; then
		LOCALE=$(basename "$f")
		find . -type f -name "*.php" | xgettext --language=PHP --add-comments=L10N -d core --keyword=___:1 --keyword=___:1,2c --keyword=n___:1,2 --keyword=n___:1,2,4c -o "locale/${LOCALE}/LC_MESSAGES/core.po.new" -f -
		if [ -f "locale/${LOCALE}/LC_MESSAGES/core.po" ]; then
			msgmerge -U -N "locale/${LOCALE}/LC_MESSAGES/core.po" "locale/${LOCALE}/LC_MESSAGES/core.po.new"
			rm "locale/${LOCALE}/LC_MESSAGES/core.po.new"
		else
			mv "locale/${LOCALE}/LC_MESSAGES/core.po.new" "locale/${LOCALE}/LC_MESSAGES/core.po"
		fi
		msgfmt -c -o "locale/${LOCALE}/LC_MESSAGES/core.mo" "locale/${LOCALE}/LC_MESSAGES/core.po"
	fi
done
