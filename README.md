# HAL+HTK = HAUL1
*HotKey's Average Language* and *HAL Translation Kernels*

## About
The goal of HAUL is to have a piece of code that can translate itself into any other language. (See also: [Transpiler](https://en.wikipedia.org/wiki/Source-to-source_compiler), [Quine](https://en.wikipedia.org/wiki/Quine_(computing)), [LLVM](https://llvm.org/), etc.)

HAUL1 consists of the language *HAL* (HotKey's Average Language) and *HTKs* (HAL Translation Kernels) which can translate that *HAL* language into other scripting languages.

HAUL1 can also translate its own source code, which makes things really mind boggling...

Oh, and it comes with *ShadowRunner*, a simple VM that is written in *HAL* and which can be programmed for using *HAL*. A nice strange loop, don't you think?

The whole thing is kept very simple. It kind of combines the worst of PHP and Assembly in one package - a nightmare to program in. Well, it was just a proof of concept. ;-)


## History
HAUL1 was in development 2011-07 - 2012-03. It has long been superseded by [HAUL2](https://github.com/hotkeymuc/haul2) and [HAUL3](https://github.com/hotkeymuc/haul3) which are written in Python and come with much more powerful lexers and parsers.


## Features and Limitations
* "Flat" translation: no lexer, compiler or AST - just a simple text-translator
* First word in each line is always the command, followed by tab separated parameters
* Written in PHP :-(
* Some kind of structure/state while parsing (instructions, expressions, ...), but no "understanding" of the code
* OOP (HTKs are classes)
* Sample Code: "shadowRunner" - a small VM
* "HYBERnation" - Programs can store their state across translations!
* Goodie: SR1 can convert HAL to shadowRunner byte code!! "YO DAWG! I HEARD YOU LIKE POLYMORPHISM..."
* Works great for what it does!
* roughly 600 lines (12kb) per translation kernel
* Language is really ugly (an "assembler php hate child") - no nested expressions, looks repetitive, generally unpleasant to code in.
* Needs a boot-strapper to initially translate itself to an executable language (translateOnce.php)
* limited syntax (assembler like - the worst quirks of all output languages combined!)
* parsing is a bit messy, since we have no syntax tree
* Can only output languages that are similar in their syntactic structure (PHP, Python, JS, VBS, ...)
> Maybe some sort of syntax tree is not bad after all... Especially for binary output.


## Usage
* Write your code in *HAL* (see `src.hal` for examples)
* Pick an output language (JS, PHP, VBS, SR), see `src.hal/htk_*.hal` for a selection
* Use `run_deploy.php` to translate the *HTK* for your desired language to PHP and invoke it on your own source file. This results in your source file being translated to any of the destination languages.
* Use `run_shadowRunner.php` to translate your source to *ShadowRunner* byte code and run it inside a *ShadowRunner* VM on the desired target platform.