<?php

abstract class StorageFactory{
	public static function getTypeRecord($storage) {
		switch ($storage) {
			case 'db':
				return new DbRecord();
			case 'xml':
				return new XmlRecord();
			case 'file':
				return new FileRecord();
		}
	}
}

