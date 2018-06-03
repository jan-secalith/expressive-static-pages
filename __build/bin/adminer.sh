#!/bin/bash

OUTPUT="/var/www/expressive/public/adminer.php"
CSS=""
DEL=30

while getopts meo:c:d: flag; do
  case $flag in
    m) MYSQL="-mysql";;
    e) EN="-en";;
    o) OUTPUT="$OPTARG";;
    c) CSS="$OPTARG";;
    d) DEL=$OPTARG;;
    ?) usage; exit;;
  esac
done

curl -s -o $OUTPUT -L "http://www.adminer.org/latest$MYSQL$EN.php" \
  && printf "Downloaded Adminer successfully\n" \
  || (printf "Error downloading Adminer\n" && exit 1)

if [ $DEL -gt 0 ]; then
  sleep $(($DEL*60)) && rm "$OUTPUT" 2>/dev/null &
fi

if [ "$CSS" != "" ]; then
  curl -s -o "adminer.css" -L "$CSS" \
    && printf "Downloaded CSS successfully\n" \
    || printf "Error downloading css\n"

  if [ $DEL -gt 0 ]; then
    sleep $(($DEL*60)) && rm "adminer.css" 2>/dev/null &
  fi
fi