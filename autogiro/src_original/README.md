Parsing autogiro files
----------------------
    use ledgr\giro\Giro;
    use ledgr\autogiro\AutogiroFactory;

    $giro = new Giro(new AutogiroFactory);
    $file = file('tests/samples/new/nya-medgivanden-internetbank.txt');
    $domDocument = $giro->convertToXML($file);


Creating autogiro files
-----------------------
    use ledgr\autogiro\Builder\AutogiroBuilder;
    use ledgr\billing\LegalPerson;

    $org = new LegalPerson(...);
    $builder = new AutogiroBuilder($org);
    $builder->addConsent(new LegalPerson(...));
    echo $builder->getNative();


Supported file formats
----------------------
Layouts A - H in the legacy Autogiro Privat.

Layouts A - C and E - J in new Autogiro (in use fall 2011). (Support for
layout D is currently missing, but the BgMax format can be used instead.)

Bankgirot standard format BgMax

[PlusGirot layout N (also known as 02P)]

    +=============================+=====+=====+=====+
    | LAYOUT                      | PRI | OLD | NEW |
    +=============================+=====+=====+=====+
    | A (Medgivandeunderlag)      |  X  |  X  |  X  |
    +-----------------------------+-----+-----+-----+
    | B (Betalningsunderlag)      |  X  |  X  |  X  |
    +-----------------------------+-----+-----+-----+
    | C (Mak./ändr. bet.underlag) |  X  |  X  |  X  |
    +-----------------------------+-----+-----+-----+
    | D (Betalningsspec.)         |  X  |  X  |  ?  |
    +-----------------------------+-----+-----+-----+
    | BGMAX (Betalningsspec.)     |  -  |  -  |  X  |
    +-----------------------------+-----+-----+-----+
    | E (Medgivandeavisering)     |  X  |  X  |  X  |
    +-----------------------------+-----+-----+-----+
    | F (Avvisade bet.)           |  X  |  X  |  X  |
    +-----------------------------+-----+-----+-----+
    | G (Mak./ändrings-lista)     |  X  |  X  |  X  |
    +-----------------------------+-----+-----+-----+
    | H (Elektr. medgivanden)     |  X  |  X  |  X  |
    +-----------------------------+-----+-----+-----+
    | I (Utdrag bevakningsreg)    |  -  |  X  |  X  |
    +-----------------------------+-----+-----+-----+
    | J (Utdrag medgivandereg)    |  -  |  X  |  X  |
    +=============================+=====+=====+=====+
      PRI = autogiro privat
      OLD = new autogiro with old layout
      NEW = nya autogiro with new layout
