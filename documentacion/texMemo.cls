% This document class provides a simple memo for LaTeX users.
% It is based on article.cls and inherits most of the functionality
% that class.
% 
% Author: Rob Oakes, Copyright 2010.  Released under the LGPL, version 3.
% A copy of the LGPL can be found at http://www.gnu.org/licenses/lgpl.html

\NeedsTeXFormat{LaTeX2e}
\ProvidesClass{texMemo}[2010/07/31 - Simple Memo Class, Including Logo]
\RequirePackage{palatino}

\usepackage{graphicx}

% Load the Base Class
\LoadClassWithOptions{article}

\usepackage[T1]{fontenc}
\usepackage[utf8]{inputenc}
\usepackage{parskip} % Adds spacing between paragraphs
\setlength{\parindent}{15pt} % Indent paragraphs
\usepackage[spanish,activeacute]{babel}
\usepackage{hyperref}


\hypersetup{colorlinks=true,
	linkcolor=black,
	citecolor=blue,
	filecolor=black,
	urlcolor=blue,
	pdfauthor=  Luis Andrés Valido Fajardo
}

\usepackage{xcolor}
\usepackage{listings}

\usepackage{eso-pic}
\newcommand\BackgroundPic{
	\put(0,0){
		\parbox[b][\paperheight]{\paperwidth}{%
			\vfill
			\centering
			\includegraphics[width=\paperwidth,height=\paperheight,
			keepaspectratio]{./img/logo6.png}%
			\vfill
}}}

\usepackage{fancyhdr}
\setlength{\headheight}{15pt}
\renewcommand{\footrulewidth}{0.4pt}


\usepackage{listings}
\lstset{ frame=Ltb,
	framerule=0pt,
	aboveskip=0.5cm,
	framextopmargin=1pt,
	framexbottommargin=1pt,
	framexleftmargin=0.4cm,
	framesep=0pt,
	rulesep=.4pt,
	backgroundcolor=\color{white},
	rulesepcolor=\color{black},
	%
	stringstyle=\ttfamily,
	showstringspaces = false,
	basicstyle=\small\ttfamily,
	commentstyle=\color{blue},
	keywordstyle=\bfseries,
	%
	numbers=none,
	numbersep=20pt,
	numberstyle=\tiny,
	numberfirstline = false,
	breaklines=true,
}
% minimizar fragmentado de listados
\lstnewenvironment{listing}[1][]
{\lstset{#1}\pagebreak[0]}{\pagebreak[0]}
\lstdefinestyle{consola}
{basicstyle=\scriptsize\bf\ttfamily,
	backgroundcolor=\color{white},
}
\lstdefinestyle{C++}
{language=C++,
}

\lstdefinestyle{DOS}
{
	backgroundcolor=\color{black},
	basicstyle=\normalsize\color{white}\ttfamily
}

% Begin Requirements
\RequirePackage{ifthen}

% Specialized memo Commands (To, From, Subject, Logo, Letterhead Address)

\def\@memoto{\relax}
\newcommand{\memoto}[1]{\gdef\@memoto{#1}}

\def\@memofrom{\relax}
\newcommand{\memofrom}[1]{\gdef\@memofrom{#1}}

\def\@memosubject{\relax}
\newcommand{\memosubject}[1]{\gdef\@memosubject{#1}}

\def\@memodate{\relax}
\newcommand{\memodate}[1]{\gdef\@memodate{#1}}

\def\@memologo{\relax}
\newcommand{\logo}[1]{\gdef\@memologo{\protect #1}}

\def\@letterheadaddress{\relax}
\newcommand{\lhaddress}[1]{\gdef\@letterheadaddress{#1}}

% Custom Document Formatting
\newcommand\decorativeline[1][1pt]{
	\par\noindent%
	\rule[0.5ex]{\linewidth}{#1}\par
}

% Set the Paper Size and margins
\RequirePackage{geometry}
\geometry{margin=1.0in,bottom=1.7in}

% Create the Letterhead and To/From Block

\renewcommand{\maketitle}{\makememotitle}
\newcommand\makememotitle{
	\ifthenelse{\equal{\@memologo}{\relax}}{}
	{ % Create With Logo
	\begin{minipage}[t]{1\columnwidth}%
		\begin{flushright}
			\vspace{-0.6in}
			\@memologo
			\vspace{0.5in}
		\par\end{flushright}%
	\end{minipage}
	}
	{\begin{flushleft}
	\MakeUppercase{\LARGE\bf Instalación y despliegue del Repositorio Documental para Acreditaciones (\emph{REDA}) }
	\end{flushleft}}
	% To, From, Subject Block
	
	\decorativeline\bigskip{}
}

\newcommand{\TODO}{

 \colorbox{red}{\huge  \textbf{FALTA POR TERMINAR}}

}