<?php

class AnalysisKeyword
{

    public function analysisKeyword($data)
    {
        $txt='';
        foreach($data['commentList'] as $comment){
            $txt.= $comment['textDisplay'];
        }

        $mecab = new MeCab_Tagger();
        $meisi = array();    //名詞配列
        $word = '';            //複合名詞保存用バッファ変数

        $word_list_index = $word_list = array();

        for ($node = $mecab->parseToNode($txt); $node; $node = $node->getNext()) {
            if ($node->getStat() != 2 && $node->getStat() != 3 && mb_strpos($node->getFeature(), '名詞', NULL, 'utf-8') === 0) {
                $word .= $node->getSurface();

                $key = array_search($word, $word_list_index);
                if ($key === false) {// 新出
                    $word_list[] = array('count' => 1, 'word' => $word);
                    $word_list_index[] = $word;
                } else {// 既出
                    $word_list[$key]['count'] = $word_list[$key]['count'] + 1;
                }

            } else if ($word != '') {
                array_push($meisi, $word);
                $word = '';
            }
        }

        unset($word_list_index);
        arsort($word_list);

        $data['analysisKeywordList'] = $word_list;

        return $data;
    }
}