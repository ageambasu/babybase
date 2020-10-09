<?php

namespace App;

use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Model;

class Baby extends Model
{
	/**
     * The dataframe equivalent.
     *
     * @var array
     */
	static $fieldName = 0;
    static $fieldType = 1;
	static $fieldValues = 2;
	static $fieldOnForm = 3;
	static $fieldRequiredOnForm = 4;
	static $fieldOnIndex = 5;
    static $fieldOnFilter = 6;
	static $fieldsOnDatabase = [
		//Personal information
		['name', 'text', '', true, true, true, false],
		['application_date', 'date', '', true, true, false, true],
		['dob', 'date', '', true, true, false, true],
		['age_today', 'text', '', false, false, true, true],
		['sex', 'select', ['Female', 'Male'], true, true, true, true],
		['monolingual_dutch', 'select', ['Yes', 'No'], true, true, true, true],
		['other_languages', 'multiselect', ['Abkhazian (ab)','Achinese (ace)','Acoli (ach)','Adangme (ada)','Adyghe (ady)','Afar (aa)','Afrihili (afh)','Afrikaans (af)','Aghem (agq)','Ainu (ain)','Akan (ak)','Akkadian (akk)','Akoose (bss)','Alabama (akz)','Albanian (sq)','Aleut (ale)','Algerian Arabic (arq)','Amarik (am)','American English (en_US)','American Sign Language (ase)','Ancient Egyptian (egy)','Ancient Greek (grc)','Angika (anp)','Ao Naga (njo)','Arabik (ar)','Aragonese (an)','Aramaic (arc)','Araona (aro)','Arapaho (arp)','Arawak (arw)','Armenian (hy)','Aromanian (rup)','Arpitan (frp)','Assamese (as)','Asturian (ast)','Asu (asa)','Atsam (cch)','Australian English (en_AU)','Austrian German (de_AT)','Avaric (av)','Avestan (ae)','Awadhi (awa)','Aymara (ay)','Azerbaijani (az)','Badaga (bfq)','Bafia (ksf)','Bafut (bfd)','Bakhtiari (bqi)','Balinese (ban)','Baluchi (bal)','Bambara (bm)','Bamun (bax)','Banjar (bjn)','Basaa (bas)','Bashkir (ba)','Basque (eu)','Batak Toba (bbc)','Bavarian (bar)','Beja (bej)','Belarus kasa (be)','Bemba (bem)','Bena (bez)','Bengali kasa (bn)','Betawi (bew)','Bɛɛmis kasa (my)','Bhojpuri (bho)','Bikol (bik)','Bini (bin)','Bishnupriya (bpy)','Bislama (bi)','Blin (byn)','Blissymbols (zbl)','Bodo (brx)','Borɔfo (en)','Bosnian (bs)','Bɔlgeria kasa (bg)','Brahui (brh)','Braj (bra)','Brazilian Portuguese (pt_BR)','Breton (br)','British English (en_GB)','Buginese (bug)','Bulu (bum)','Buriat (bua)','Caddo (cad)','Cajun French (frc)','Canadian English (en_CA)','Canadian French (fr_CA)','Cantonese (yue)','Capiznon (cps)','Carib (car)','Catalan (ca)','Cayuga (cay)','Cebuano (ceb)','Central Atlas Tamazight (tzm)','Central Dusun (dtp)','Central Kurdish (ckb)','Central Yupik (esu)','Chadian Arabic (shu)','Chagatai (chg)','Chamorro (ch)','Chechen (ce)','Cherokee (chr)','Cheyenne (chy)','Chibcha (chb)','Chiga (cgg)','Chimborazo Highland Quichua (qug)','Chinook Jargon (chn)','Chipewyan (chp)','Choctaw (cho)','Church Slavic (cu)','Chuukese (chk)','Chuvash (cv)','Classical Newari (nwc)','Classical Syriac (syc)','Colognian (ksh)','Comorian (swb)','Congo Swahili (swc)','Coptic (cop)','Cornish (kw)','Corsican (co)','Cree (cr)','Creek (mus)','Crimean Turkish (crh)','Croatian (hr)','Dakota (dak)','Danish (da)','Dargwa (dar)','Dazaga (dzg)','Delaware (del)','Dɛɛkye (nl)','Dinka (din)','Divehi (dv)','Dogri (doi)','Dogrib (dgr)','Duala (dua)','Dyula (dyu)','Dzongkha (dz)','Eastern Frisian (frs)','Efik (efi)','Egyptian Arabic (arz)','Ekajuk (eka)','Elamite (elx)','Embu (ebu)','Emilian (egl)','Erzya (myv)','Esperanto (eo)','Estonian (et)','European Portuguese (pt_PT)','European Spanish (es_ES)','Ewe (ee)','Ewondo (ewo)','Extremaduran (ext)','Fang (fan)','Fanti (fat)','Faroese (fo)','Fiji Hindi (hif)','Fijian (fj)','Filipino (fil)','Finnish (fi)','Flemish (nl_BE)','Fon (fon)','Frafra (gur)','Frɛnkye (fr)','Friulian (fur)','Fulah (ff)','Ga (gaa)','Gagauz (gag)','Galician (gl)','Gan Chinese (gan)','Ganda (lg)','Gayo (gay)','Gbaya (gba)','Geez (gez)','Georgian (ka)','Gheg Albanian (aln)','Ghomala (bbj)','Gilaki (glk)','Gilbertese (gil)','Goan Konkani (gom)','Gondi (gon)','Gorontalo (gor)','Gothic (got)','Grebo (grb)','Greek kasa (el)','Guarani (gn)','Gujarati (gu)','Gusii (guz)','Gwichʼin (gwi)','Gyaaman (de)','Gyabanis kasa (jv)','Gyapan kasa (ja)','Haida (hai)','Haitian (ht)','Hakka Chinese (hak)','Hangri kasa (hu)','Hausa (ha)','Hawaiian (haw)','Hebrew (he)','Herero (hz)','Hiligaynon (hil)','Hindi (hi)','Hiri Motu (ho)','Hittite (hit)','Hmong (hmn)','Hupa (hup)','Iban (iba)','Ibibio (ibb)','Icelandic (is)','Ido (io)','Igbo (ig)','Iloko (ilo)','Inari Sami (smn)','Indonihyia kasa (id)','Ingrian (izh)','Ingush (inh)','Interlingua (ia)','Interlingue (ie)','Inuktitut (iu)','Inupiaq (ik)','Irish (ga)','Italy kasa (it)','Jamaican Creole English (jam)','Jju (kaj)','Jola-Fonyi (dyo)','Judeo-Arabic (jrb)','Judeo-Persian (jpr)','Jutish (jut)','Kabardian (kbd)','Kabuverdianu (kea)','Kabyle (kab)','Kachin (kac)','Kaingang (kgp)','Kako (kkj)','Kalaallisut (kl)','Kalenjin (kln)','Kalmyk (xal)','Kamba (kam)','Kambodia kasa (km)','Kanembu (kbl)','Kannada (kn)','Kanuri (kr)','Kara-Kalpak (kaa)','Karachay-Balkar (krc)','Karelian (krl)','Kashmiri (ks)','Kashubian (csb)','Kawi (kaw)','Kazakh (kk)','Kenyang (ken)','Khasi (kha)','Khotanese (kho)','Khowar (khw)','Kikuyu (ki)','Kimbundu (kmb)','Kinaray-a (krj)','Kirmanjki (kiu)','Klingon (tlh)','Kom (bkm)','Komi (kv)','Komi-Permyak (koi)','Kongo (kg)','Konkani (kok)','Korea kasa (ko)','Koro (kfo)','Kosraean (kos)','Kotava (avk)','Koyra Chiini (khq)','Koyraboro Senni (ses)','Kpelle (kpe)','Krio (kri)','Kuanyama (kj)','Kumyk (kum)','Kurdish (ku)','Kurukh (kru)','Kutenai (kut)','Kwasio (nmg)','Kyaena kasa (zh)','Kyɛk kasa (cs)','Kyrgyz (ky)','Kʼicheʼ (quc)','Ladino (lad)','Lahnda (lah)','Lakota (lkt)','Lamba (lam)','Langi (lag)','Lao (lo)','Latgalian (ltg)','Latin (la)','Latin American Spanish (es_419)','Latvian (lv)','Laz (lzz)','Lezghian (lez)','Ligurian (lij)','Limburgish (li)','Lingala (ln)','Lingua Franca Nova (lfn)','Literary Chinese (lzh)','Lithuanian (lt)','Livonian (liv)','Lojban (jbo)','Lombard (lmo)','Low German (nds)','Lower Silesian (sli)','Lower Sorbian (dsb)','Lozi (loz)','Luba-Katanga (lu)','Luba-Lulua (lua)','Luiseno (lui)','Lule Sami (smj)','Lunda (lun)','Luo (luo)','Luxembourgish (lb)','Luyia (luy)','Maba (mde)','Macedonian (mk)','Machame (jmc)','Madurese (mad)','Mafa (maf)','Magahi (mag)','Main-Franconian (vmf)','Maithili (mai)','Makasar (mak)','Makhuwa-Meetto (mgh)','Makonde (kde)','Malagasy (mg)','Malay kasa (ms)','Malayalam (ml)','Maltese (mt)','Manchu (mnc)','Mandar (mdr)','Mandingo (man)','Manipuri (mni)','Manx (gv)','Maori (mi)','Mapuche (arn)','Marathi (mr)','Mari (chm)','Marshallese (mh)','Marwari (mwr)','Masai (mas)','Mazanderani (mzn)','Medumba (byv)','Mende (men)','Mentawai (mwv)','Meru (mer)','Metaʼ (mgo)','Mexican Spanish (es_MX)','Micmac (mic)','Middle Dutch (dum)','Middle English (enm)','Middle French (frm)','Middle High German (gmh)','Middle Irish (mga)','Min Nan Chinese (nan)','Minangkabau (min)','Mingrelian (xmf)','Mirandese (mwl)','Mizo (lus)','Modern Standard Arabic (ar_001)','Mohawk (moh)','Moksha (mdf)','Moldavian (ro_MD)','Mongo (lol)','Mongolian (mn)','Morisyen (mfe)','Moroccan Arabic (ary)','Mossi (mos)','Multiple Languages (mul)','Mundang (mua)','Muslim Tat (ttt)','Myene (mye)','Nama (naq)','Nauru (na)','Navajo (nv)','Ndonga (ng)','Neapolitan (nap)','Newari (new)','Nɛpal kasa (ne)','Ngambay (sba)','Ngiemboon (nnh)','Ngomba (jgo)','Nheengatu (yrl)','Nias (nia)','Niuean (niu)','No linguistic content (zxx)','Nogai (nog)','North Ndebele (nd)','Northern Frisian (frr)','Northern Sami (se)','Northern Sotho (nso)','Norwegian (no)','Norwegian Bokmål (nb)','Norwegian Nynorsk (nn)','Novial (nov)','Nuer (nus)','Nyamwezi (nym)','Nyanja (ny)','Nyankole (nyn)','Nyasa Tonga (tog)','Nyoro (nyo)','Nzima (nzi)','NʼKo (nqo)','Occitan (oc)','Ojibwa (oj)','Old English (ang)','Old French (fro)','Old High German (goh)','Old Irish (sga)','Old Norse (non)','Old Persian (peo)','Old Provençal (pro)','Oriya (or)','Oromo (om)','Osage (osa)','Ossetic (os)','Ottoman Turkish (ota)','Pahlavi (pal)','Palatine German (pfl)','Palauan (pau)','Pali (pi)','Pampanga (pam)','Pangasinan (pag)','Papiamento (pap)','Pashto (ps)','Pennsylvania German (pdc)','Pɛɛhyia kasa (fa)','Phoenician (phn)','Picard (pcd)','Piedmontese (pms)','Plautdietsch (pdt)','Pohnpeian (pon)','Pontic (pnt)','Pɔland kasa (pl)','Pɔɔtugal kasa (pt)','Prussian (prg)','Pungyabi kasa (pa)','Quechua (qu)','Rahyia kasa (ru)','Rajasthani (raj)','Rapanui (rap)','Rarotongan (rar)','Rewanda kasa (rw)','Riffian (rif)','Romagnol (rgn)','Romansh (rm)','Romany (rom)','Rombo (rof)','Romenia kasa (ro)','Root (root)','Rotuman (rtm)','Roviana (rug)','Rundi (rn)','Rusyn (rue)','Rwa (rwk)','Saho (ssy)','Sakha (sah)','Samaritan Aramaic (sam)','Samburu (saq)','Samoan (sm)','Samogitian (sgs)','Sandawe (sad)','Sango (sg)','Sangu (sbp)','Sanskrit (sa)','Santali (sat)','Sardinian (sc)','Sasak (sas)','Sassarese Sardinian (sdc)','Saterland Frisian (stq)','Saurashtra (saz)','Scots (sco)','Scottish Gaelic (gd)','Selayar (sly)','Selkup (sel)','Sena (seh)','Seneca (see)','Serbian (sr)','Serbo-Croatian (sh)','Serer (srr)','Seri (sei)','Shambala (ksb)','Shan (shn)','Shona (sn)','Sichuan Yi (ii)','Sicilian (scn)','Sidamo (sid)','Siksika (bla)','Silesian (szl)','Simplified Chinese (zh_Hans)','Sindhi (sd)','Sinhala (si)','Skolt Sami (sms)','Slave (den)','Slovak (sk)','Slovenian (sl)','Soga (xog)','Sogdien (sog)','Somalia kasa (so)','Soninke (snk)','South Azerbaijani (azb)','South Ndebele (nr)','Southern Altai (alt)','Southern Sami (sma)','Southern Sotho (st)','Spain kasa (es)','Sranan Tongo (srn)','Standard Moroccan Tamazight (zgh)','Sukuma (suk)','Sumerian (sux)','Sundanese (su)','Susu (sus)','Swahili (sw)','Swati (ss)','Sweden kasa (sv)','Swiss French (fr_CH)','Swiss German (gsw)','Swiss High German (de_CH)','Syriac (syr)','Tachelhit (shi)','Taeland kasa (th)','Tagalog (tl)','Tahitian (ty)','Taita (dav)','Tajik (tg)','Talysh (tly)','Tamashek (tmh)','Tamil kasa (ta)','Taroko (trv)','Tasawaq (twq)','Tatar (tt)','Telugu (te)','Tereno (ter)','Teso (teo)','Tetum (tet)','Tɛɛki kasa (tr)','Tibetan (bo)','Tigre (tig)','Tigrinya (ti)','Timne (tem)','Tiv (tiv)','Tlingit (tli)','Tok Pisin (tpi)','Tokelau (tkl)','Tongan (to)','Tornedalen Finnish (fit)','Traditional Chinese (zh_Hant)','Tsakhur (tkr)','Tsakonian (tsd)','Tsimshian (tsi)','Tsonga (ts)','Tswana (tn)','Tulu (tcy)','Tumbuka (tum)','Tunisian Arabic (aeb)','Turkmen (tk)','Turoyo (tru)','Tuvalu (tvl)','Tuvinian (tyv)','Twi (tw)','Tyap (kcg)','Udmurt (udm)','Ugaritic (uga)','Ukren kasa (uk)','Umbundu (umb)','Unknown Language (und)','Upper Sorbian (hsb)','Urdu kasa (ur)','Uyghur (ug)','Uzbek (uz)','Vai (vai)','Venda (ve)','Venetian (vec)','Veps (vep)','Viɛtnam kasa (vi)','Volapük (vo)','Võro (vro)','Votic (vot)','Vunjo (vun)','Walloon (wa)','Walser (wae)','Waray (war)','Warlpiri (wbp)','Washo (was)','Wayuu (guc)','Welsh (cy)','West Flemish (vls)','Western Frisian (fy)','Western Mari (mrj)','Wolaytta (wal)','Wolof (wo)','Wu Chinese (wuu)','Xhosa (xh)','Xiang Chinese (hsn)','Yangben (yav)','Yao (yao)','Yapese (yap)','Yemba (ybb)','Yiddish (yi)','Yoruba (yo)','Zapotec (zap)','Zarma (dje)','Zaza (zza)','Zeelandic (zea)','Zenaga (zen)','Zhuang (za)','Zoroastrian Dari (gbz)','Zulu (zu)','Zuni (zun)'], true, false, false, true],
		['parent_firstname', 'text', '', true, true, false, false],
		['parent_lastname', 'text', '', true, true, false, false],
		['phone', 'tel', '', true, true, false, false],
		['email', 'email', '', true, true, false, false],
		['street', 'text', '', true, false, false, false],
		['house_number', 'number', '', true, false, false, false],
		['postcode', 'text', '', true, false, false, true],
		['city', 'text', '', true, false, true, true],
		['recruitment_source', 'select', ['Mail', 'Website', 'Flyer consultatiebureau', 'Flyer daycare', 'Friend', 'Facebook'], true, true, false, true],

		//Appointment information
		['preferred_appointment_days', 'multiselect', ['None', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'], true, true, false, true],
		['appointment_date', 'date', '', true, false, false, false],
		['appointment_time', 'time', '', true, false, false, false],
		['age_at_appointment', 'text', '', false, false, false, false],
		['appointment_number', 'number', '', true, true, false, true],
		['appointment_status', 'select', ['New', 'Contacted', 'In progress', 'Completed'], true, true, false, true],

        ['notes', 'text', '', true, false, false, false],
    ];

    /**
     * The rules to validate.
     *
     * @var array
     */
    public static $validationRules = [
            //Personal information
            'name' => 'required|string|min:2|max:255',
            'application_date' => 'required|date|date_format:Y-m-d',
            'dob' => 'required|date',
            'sex' => 'required',
            'monolingual_dutch' => 'required',
            'other_languages' => 'nullable',
            'parent_firstname' => 'required|string|min:2|max:255',
            'parent_lastname' => 'required|string|min:2|max:255',
            'phone' =>  'required|numeric|digits_between:3,16',
            'email' => 'required|email',
            'street' => 'nullable|string|min:2|max:255',
            'house_number' =>  'nullable|numeric',
            'postcode' =>  'nullable|string|min:2|max:255',
            'city' =>  'nullable|string|min:2|max:255',
            'recruitment_source' =>  'required',

            //Appointment information
            'preferred_appointment_days' =>  'required',
            'appointment_date' => 'nullable|date|date_format:Y-m-d',
            'appointment_time' => 'nullable',
            'appointment_number' => 'required|numeric',
            'appointment_status' => 'required',

            'notes' => 'nullable|string|min:2|max:255',
        ];

	/**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Returns the url path for the instance.
     *
     * @param  \App\Baby  $baby
     * @return url path
     */
    public function path()
    {
        return route('babies.show', $this);
    }

    /**
     * Returns the current age of a baby.
     *
     * @param  \App\Baby  $baby->dob
     * @return current age
     */
    public function getBabyAgeToday()
    {
    	$dobToDate = \Carbon\Carbon::createFromFormat('Y-m-d', $this->dob);      

        $carbonDate = $dobToDate->diff(\Carbon\Carbon::now())->format('%y,%m,%d');
        
        $carbonArray = explode(',', $carbonDate);
        
        $dateMonthsDays=[0=>(int)$carbonArray[0] * 12 + (int)$carbonArray[1], 1=>(int)$carbonArray[2]];

        $dateMonthsDays = implode(';', $dateMonthsDays);

        return $dateMonthsDays;
    }

    /**
     * Returns the age of a baby at the appointment date.
     *
     * @param  \App\Baby  $baby->dob
     * @param  \App\Baby  $baby->appointment_date
     * @return age at appointment
     */
    public function getBabyAgeAtAppointment()
    {
        $dobToDate = \Carbon\Carbon::createFromFormat('Y-m-d', $this->dob);
        $appDateToDate = \Carbon\Carbon::createFromFormat('Y-m-d', $this->application_date);    

        $carbonDate = $dobToDate->diff($appDateToDate)->format('%y,%m,%d');

        $carbonArray = explode(',', $carbonDate);
        
        $dateMonthsDays=[0=>(int)$carbonArray[0] * 12 + (int)$carbonArray[1], 1=>(int)$carbonArray[2]];

        $dateMonthsDays = implode(';', $dateMonthsDays);

        return $dateMonthsDays;
    }

    /**
     * Returns all the studies linked to the baby.
     *
     * @param  \App\Baby  $baby
     * @return collection of studies for the selected baby
     */
    public function studies()
    {
        return $this->belongsToMany(Study::class)->withTimestamps();
    }


    /**
     * Returns the url path for the instance.
     *
     * @param  $query
     * @param  \App\Filters  $filters
     * @return selected filters
     */
    public function scopeFilterBabies($query, array $filters = []) 
    {
        if ($filters) {
            foreach ($filters as $column => $value) {
                if (in_array($column, $this->getFilterColumns())) {
                    $query->where($column, '=', $value); 
                }
            }

        }
    }

    /**
     * Returns the url path for the instance.
     *
     * @param  $query
     * @param  \App\Filters  $filters
     * @return selected filters
     */
    public function scopeFilterStudies($query, array $filters = []) 
    {
        if ($filters) {
            return $this->whereHas('studies' , function ($query) use ($filters) {
                foreach ($filters as $column => $value) {
                    if (in_array($column, $query->getModel()->getFilterColumns())) { 
                        $query->where($column, '=', $value); 
                    }
                }
            });
        }
    }

    /**
     * Returns all keys of Baby.
     *
     * @param  \App\Baby  self
     * @return all keys
     */
    public function getFilterColumns() : array 
    {
        return array_keys(self::$validationRules);
    }
}