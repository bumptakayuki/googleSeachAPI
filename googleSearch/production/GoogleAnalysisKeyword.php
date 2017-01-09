<?php

class GoogleAnalysisKeyword
{

    public function analysisKeyword($bodyKeywordData)
    {

        $outputs = array_reverse(preg_split("/EOS|\n/u", shell_exec(sprintf('echo %s | /usr/local/bin/juman', escapeshellarg($bodyKeywordData)))));

        // 名詞を抽出
        $meisiList = [];    //名詞配列
        foreach ($outputs as $output) {
            if (preg_match('/名詞/', $output)) {
                $chars = preg_split('/ /', $output, -1, PREG_SPLIT_OFFSET_CAPTURE);
                $meisiList[] = $chars[0][0];
            }
        }

        $word_list = [];
        $word_list_index = [];

        foreach ($meisiList as $meisi) {
            $key = array_search($meisi, $word_list_index);
            if ($key === false) {// 新出
                if($meisi=='@'){
                    continue;
                }
                $word_list[] = ['count' => 1, 'word' => $meisi];
                $word_list_index[] = $meisi;
            } else {// 既出
                $word_list[$key]['count'] = $word_list[$key]['count'] + 1;
            }
        }

        unset($word_list_index);
        arsort($word_list);

        return $word_list;
    }
}